<?php

declare(strict_types=1);

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * Class AuditManyToManyChanges
 *
 * This is a very simple and naive check for sync/attach/detach(). Realistically it should check the previous
 * method for a many-to-many relationship. This should be done later perhaps.
 */
class AuditManyToManyChanges implements Rule
{
    public function getNodeType(): string
    {
        return Node\Expr\MethodCall::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        /** @var Node\Identifier $syncMethodCall */
        $syncMethodCall = $node->name;

        if (!in_array($syncMethodCall->name, ['attach', 'detach', 'sync'])) {
            return [];
        }

        return [
            RuleErrorBuilder::message('Auditing missing for many-to-many relationship alteration.')
                ->identifier('app.auditmanytomanychanges')
                ->build(),
        ];
    }
}
