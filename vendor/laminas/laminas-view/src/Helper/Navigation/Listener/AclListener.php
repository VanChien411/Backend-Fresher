<?php

declare(strict_types=1);

namespace Laminas\View\Helper\Navigation\Listener;

use Laminas\EventManager\Event;

/**
 * Default Access Control Listener
 *
 * @deprecated This class has been moved to the `Laminas\Navigation` component and will be removed in 3.0
 */
class AclListener
{
    /**
     * Determines whether a page should be accepted by ACL when iterating
     *
     * - If helper has no ACL, page is accepted
     * - If page has a resource or privilege defined, page is accepted if the
     *   ACL allows access to it using the helper's role
     * - If page has no resource or privilege, page is accepted
     * - If helper has ACL and role:
     *      - Page is accepted if it has no resource or privilege.
     *      - Page is accepted if ACL allows page's resource or privilege.
     *
     * @return bool
     */
    public static function accept(Event $event)
    {
        $accepted = true;
        $params   = $event->getParams();
        $acl      = $params['acl'];
        $page     = $params['page'];
        $role     = $params['role'];

        if (! $acl) {
            return $accepted;
        }

        $resource  = $page->getResource();
        $privilege = $page->getPrivilege();

        if ($resource || $privilege) {
            $accepted = $acl->hasResource($resource)
                        && $acl->isAllowed($role, $resource, $privilege);
        }

        return $accepted;
    }
}
