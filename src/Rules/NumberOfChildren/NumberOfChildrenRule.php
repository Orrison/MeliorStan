<?php

namespace Orrison\MeliorStan\Rules\NumberOfChildren;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Node\CollectedDataNode;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<CollectedDataNode>
 */
class NumberOfChildrenRule implements Rule
{
    public const ERROR_MESSAGE_TEMPLATE = 'Class "%s" has %d direct children, exceeding the maximum of %d.';

    public function __construct(
        private Config $config
    ) {}

    public function getNodeType(): string
    {
        return CollectedDataNode::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        $childrenData = $node->get(NumberOfChildrenCollector::class);
        $declarationData = $node->get(ClassDeclarationCollector::class);

        // Build a map of class names to their file/line
        $classLocations = [];

        foreach ($declarationData as $fileDeclarations) {
            foreach ($fileDeclarations as [$className, $fileName, $line]) {
                $classLocations[$className] = [$fileName, $line];
            }
        }

        // Count children per parent
        $childrenCounts = [];

        foreach ($childrenData as $fileData) {
            foreach ($fileData as $childData) {
                foreach ($childData as $parentClassName => $count) {
                    if (! isset($childrenCounts[$parentClassName])) {
                        $childrenCounts[$parentClassName] = 0;
                    }

                    $childrenCounts[$parentClassName] += $count;
                }
            }
        }

        $maximum = $this->config->getMaximum();
        $errors = [];

        foreach ($childrenCounts as $className => $count) {
            if ($count > $maximum) {
                $errorBuilder = RuleErrorBuilder::message(
                    sprintf(
                        self::ERROR_MESSAGE_TEMPLATE,
                        $className,
                        $count,
                        $maximum
                    )
                )
                    ->identifier('MeliorStan.tooManyChildren');

                // Add file and line information if available
                if (isset($classLocations[$className])) {
                    [$fileName, $line] = $classLocations[$className];
                    $errorBuilder = $errorBuilder->file($fileName)->line($line);
                }

                $errors[] = $errorBuilder->build();
            }
        }

        return $errors;
    }
}
