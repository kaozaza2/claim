<?php

namespace App\Models\Concerns;

use Illuminate\Support\Str;

trait WithSearchableColumns
{
    public function searchAuto(string $needle): bool
    {
        $searches = [];
        $found = false;
        $index = 0;
        foreach (explode(' ', $needle) as $search) {
            if (Str::contains($search, ':')) {
                $found = true;
                $searches[] = explode(':', $search);
            } else {
                if ($found || !array_key_exists($index - 1, $searches)) {
                    $searches[] = $search;
                } else {
                    $searches[--$index] .= ' ' . $search;
                }
                $found = false;
            }
            $index++;
        }

        foreach ($searches as $search) {
            if (is_array($search)) {
                if ($this->searchInColumn($search[0], $search[1])) {
                    return true;
                }
            } else if ($this->searchAnyColumn($search)) {
                return true;
            }
        }
        return false;
    }

    public function searchInColumn(string $column, string $needle): bool
    {
        $excludes = $this->excludes ?: [];

        if (in_array($column, $excludes)) {
            return false;
        }

        if ($this->isRelation($key = $column) || $this->isRelation($key = Str::camel($column))) {
            $relation = $this->getRelationValue($key);
            if (method_exists($relation, 'searchAuto') && $relation->searchAuto($needle)) {
                return true;
            }
        }

        if (!is_array($value = $this->getAttributeValue($column))) {
            return Str::contains($value, $needle);
        }

        return false;
    }

    public function searchAnyColumn(string $needle): bool
    {
        foreach (array_keys($this->toArray()) as $column) {
            if ($this->searchInColumn($column, $needle)) {
                return true;
            }
        }
        return false;
    }
}
