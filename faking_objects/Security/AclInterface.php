<?php

interface Security_AclInterface
{
	
    /**
     * Allow a role a privilege on an object.
     *
     * @return array
     */
    public function allow($objectType, $role, $privilege);
    
    /**
     * Allow a role a privilege on a specific field of an object.
     * 
     * @param unknown $objectType
     * @param unknown $field
     * @param unknown $role
     * @param unknown $privilege
     */
    public function allowField($objectType, $field, $role, $privilege);

    /**
     * Determines whether field access is granted
     *
     * @param string  $field
     * @param array   $masks
     * @param array   $securityIdentities
     * @param Boolean $administrativeMode
     * @return Boolean
     */
    public function isFieldGranted($objectType, $field, $privilege, Security_AuthInterface $userAuth, $administrativeMode = false);

    /**
     * Determines whether access is granted
     *
     * @throws NoAceFoundException when no ACE was applicable for this request
     * @param array   $masks
     * @param array   $securityIdentities
     * @param Boolean $administrativeMode
     * @return Boolean
     */
    public function isGranted($objectType, $privilege, Security_AuthInterface $userAuth, $administrativeMode = false);

}
