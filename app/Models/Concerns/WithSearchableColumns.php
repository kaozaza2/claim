<?php

namespace App\Models\Concerns;

use Illuminate\Support\Str;

trait WithSearchableColumns
{
    public function searchAuto(string $needle): bool
    {
        $searches = [];
        $keywords = [];
        $lastIsKeyword = false;
        foreach (explode(' ', $needle) as $search) {
            if (Str::contains($search, ':')) {
                $lastIsKeyword = true;
                $keywords[Str::before($search, ':')] = Str::after($search, ':');
            } else {
                if ($lastIsKeyword || empty($searches)) {
                    $searches[] = $search;
                } else {
                    $searches[array_key_last($searches)] .= ' ' . $search;
                }
                $lastIsKeyword = false;
            }
        }

        foreach ($keywords as $column => $search) {
            if (!$this->searchInColumn($column, $search)) {
                return false;
            }
        }

        $foundInColumn = empty($searches);
        foreach ($searches as $search) {
            if ($this->searchAnyColumn($search, !empty($keywords))) {
                $foundInColumn = true;
                break;
            }
        }

        return $foundInColumn;
    }

    public function searchInColumn(string $column, string $needle): bool
    {
        if (in_array($column, $this->excludes ?: [])) {
            return false;
        }

        if ($this->isRelation($column) && $relation = $this->getRelationValue($column)) {
            if (method_exists($relation, 'searchAuto') && $relation->searchAuto($needle)) {
                return true;
            }
        }

        if (!is_array($value = $this->getAttributeValue($column))) {
            return Str::contains($value, $needle);
        }

        return false;
    }

    public function searchAnyColumn(string $needle, bool $strict = false): bool
    {
        $columns = array_keys(
            $strict ? $this->attributesToArray() : $this->toArray()
        );
        foreach ($columns as $column) {
            if ($this->searchInColumn($column, $needle)) {
                return true;
            }
        }
        return false;
    }
}
