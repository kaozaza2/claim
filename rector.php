<?php

declare(strict_types=1);

use Rector\Core\Configuration\Option;
use Rector\Core\ValueObject\PhpVersion;
use Rector\Php74\Rector\Property\TypedPropertyRector;
use Rector\CodeQuality\Rector\FuncCall\CompactToVariablesRector;
use Rector\CodeQuality\Rector\Concat\JoinStringConcatRector;
use Rector\CodeQuality\Rector\FunctionLike\RemoveAlwaysTrueConditionSetInConstructorRector;
use Rector\CodeQuality\Rector\BooleanAnd\SimplifyEmptyArrayCheckRector;
use Rector\CodingStyle\Rector\Stmt\NewlineAfterStatementRector;
use Rector\CodingStyle\Rector\FuncCall\PreslashSimpleFunctionRector;
use Rector\CodingStyle\Rector\Use_\SeparateMultiUseImportsRector;
use Rector\Order\Rector\Class_\OrderPrivateMethodsByUseRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddArrayParamDocTypeRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddArrayReturnDocTypeRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddMethodCallBasedStrictParamTypeRector;
use Rector\TypeDeclaration\Rector\Property\CompleteVarDocTypePropertyRector;
use Rector\TypeDeclaration\Rector\Property\PropertyTypeDeclarationRector;
use Rector\Set\ValueObject\SetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    // get parameters
    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PATHS, [
        __DIR__ . '/app',
        __DIR__ . '/database/factories',
        __DIR__ . '/database/seeders',
    ]);

    $parameters->set(Option::SKIP, [
        __DIR__ . '/app/Http/Kernel.php',
    ]);

    $parameters->set(Option::PHP_VERSION_FEATURES, PhpVersion::PHP_72);

    // Define what rule sets will be applied
    $containerConfigurator->import(SetList::DEAD_CODE);
    $containerConfigurator->import(SetList::CODE_QUALITY);

    // get services (needed for register a single rule)
    $services = $containerConfigurator->services();

    // register a single rule
    $services->set(TypedPropertyRector::class);
    $services->set(CompactToVariablesRector::class);
    $services->set(JoinStringConcatRector::class);
    $services->set(RemoveAlwaysTrueConditionSetInConstructorRector::class);
    $services->set(SimplifyEmptyArrayCheckRector::class);
    $services->set(NewlineAfterStatementRector::class);
    $services->set(PreslashSimpleFunctionRector::class);
    $services->set(SeparateMultiUseImportsRector::class);
    $services->set(OrderPrivateMethodsByUseRector::class);
    $services->set(AddArrayParamDocTypeRector::class);
    $services->set(AddArrayReturnDocTypeRector::class);
    $services->set(AddMethodCallBasedStrictParamTypeRector::class);
    $services->set(CompleteVarDocTypePropertyRector::class);
    $services->set(PropertyTypeDeclarationRector::class);
};
