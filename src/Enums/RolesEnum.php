<?php 

namespace App\Enums;

/**
 * Roles Enum
 */
class RolesEnum
{

    const TYPE_INFO    = "info";
    const TYPE_WARNING = "warning";
    const TYPE_SUCCESS = "success";
    const TYPE_DANGER  = "danger";

    /** @var array user friendly named type */
    protected static $typeName = [
        self::TYPE_INFO    => 'Information',
        self::TYPE_WARNING => 'Attention',
        self::TYPE_SUCCESS => 'Succès',
        self::TYPE_DANGER  => 'Danger',
    ];

    /**
     * @param  string $typeShortName
     * @return string
     */
    public static function getTypeName($typeShortName)
    {
        if (!isset(static::$typeName[$typeShortName])) {
            return "Unknown type ($typeShortName)";
        }

        return static::$typeName[$typeShortName];
    }

    /**
     * @return array<string>
     */
    public static function getAvailableTypes()
    {
        return [
            self::TYPE_INFO,
            self::TYPE_WARNING,
            self::TYPE_SUCCESS,
            self::TYPE_DANGER
        ];
    }
}
// 	public $roles  = [
// 		'ROLE_ADMIN',
// 		'ROLE_USER',
// 		'ROLE_SUPERADMIN'
// 	]; 

// 	/**
//      * Returns the roles or permissions granted to the user for security.
//      */
//     public function getRoles(): array
//     {
//         $roles = $this->roles;

//         // guarantees that a user always has at least one role for security
//         if (empty($roles)) {
//             $roles[] = 'ROLE_USER';
//         }

//         return array_unique($roles);
//     }
// }
 ?>