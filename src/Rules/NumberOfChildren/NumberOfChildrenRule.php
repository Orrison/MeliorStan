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
    public const string ERROR_MESSAGE_TEMPLATE = 'Class "%s" has %d direct children, exceeding the maximum of %d.';

    public function __construct(
        private Config $config
    ) {}

    public function getNodeType(): string
    {
        return CollectedDataNode::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        $collectedData = $node->get(NumberOfChildrenCollector::class);

        // First pass: Build a map of class names to their file/line
        $classLocations = [];

        foreach ($collectedData as $fileData) {
            foreach ($fileData as $data) {
                $classLocations[$data['className']] = [
                    'file' => $data['file'],
                    'line' => $data['line'],
                ];
            }
        }

        // Second pass: Count children per parent
        $parentChildCounts = [];

        foreach ($collectedData as $fileData) {
            foreach ($fileData as $data) {
                if ($data['parent'] !== null) {
                    if (! isset($parentChildCounts[$data['parent']])) {
                        $parentChildCounts[$data['parent']] = 0;
                    }

                    $parentChildCounts[$data['parent']]++;
                }
            }
        }

        // Check for violations
        $errors = [];
        $maximum = $this->config->getMaximum();

        foreach ($parentChildCounts as $parentClassName => $count) {
            if ($count > $maximum) {
                $errorBuilder = RuleErrorBuilder::message(
                    sprintf(self::ERROR_MESSAGE_TEMPLATE, $parentClassName, $count, $maximum)
                )->identifier('MeliorStan.tooManyChildren');

                // Add file and line information if available
                if (isset($classLocations[$parentClassName])) {
                    $errorBuilder = $errorBuilder
                        ->file($classLocations[$parentClassName]['file'])
                        ->line($classLocations[$parentClassName]['line']);
                }

                $errors[] = $errorBuilder->build();
            }
        }

        return $errors;
    }
}
