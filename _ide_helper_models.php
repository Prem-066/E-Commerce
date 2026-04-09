<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property string $id
 * @property int $store_id
 * @property int $created_by
 * @property string $name
 * @property string|null $slug
 * @property string|null $description
 * @property string|null $image
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $creator
 * @property-read \App\Models\store $store
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Subcategory> $subcategories
 * @property-read int|null $subcategories_count
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property int $user_id
 * @property int $store_id
 * @property int $admin_id
 * @property string|null $phone
 * @property string|null $address
 * @property string|null $salary
 * @property string|null $joining_date
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Manager newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Manager newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Manager query()
 * @method static \Illuminate\Database\Eloquent\Builder|Manager whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manager whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manager whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manager whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manager whereJoiningDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manager wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manager whereSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manager whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manager whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manager whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manager whereUserId($value)
 */
	class Manager extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property int $store_id
 * @property int $created_by
 * @property string $category_id
 * @property string|null $subcategory_id
 * @property string $name
 * @property string $slug
 * @property string|null $sku
 * @property string|null $description
 * @property string $price
 * @property string $stock
 * @property string|null $image
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category|null $category
 * @property-read \App\Models\User $creator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductImage> $gallery
 * @property-read int|null $gallery_count
 * @property-read \App\Models\store $store
 * @property-read \App\Models\Subcategory|null $subcategory
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSubcategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $product_id
 * @property string $image_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage whereUpdatedAt($value)
 */
	class ProductImage extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $store_id
 * @property string|null $store_email
 * @property string|null $store_phone
 * @property string|null $store_address
 * @property string|null $gst_number
 * @property string|null $logo
 * @property string|null $smtp_host
 * @property string|null $smtp_port
 * @property string|null $smtp_username
 * @property string|null $smtp_password
 * @property string|null $smtp_encryption
 * @property string|null $mail_from_address
 * @property string|null $mail_from_name
 * @property int $email_enabled
 * @property int $notification_enabled
 * @property string|null $invoice_prefix
 * @property string $currency
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\store $store
 * @method static \Illuminate\Database\Eloquent\Builder|StoreSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StoreSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StoreSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|StoreSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreSetting whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreSetting whereEmailEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreSetting whereGstNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreSetting whereInvoicePrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreSetting whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreSetting whereMailFromAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreSetting whereMailFromName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreSetting whereNotificationEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreSetting whereSmtpEncryption($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreSetting whereSmtpHost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreSetting whereSmtpPassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreSetting whereSmtpPort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreSetting whereSmtpUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreSetting whereStoreAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreSetting whereStoreEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreSetting whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreSetting whereStorePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreSetting whereUpdatedAt($value)
 */
	class StoreSetting extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property int $store_id
 * @property string $category_id
 * @property int $created_by
 * @property string $name
 * @property string|null $slug
 * @property string|null $description
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category $category
 * @property-read \App\Models\User $creator
 * @property-read \App\Models\store $store
 * @method static \Illuminate\Database\Eloquent\Builder|Subcategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subcategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subcategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|Subcategory whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subcategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subcategory whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subcategory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subcategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subcategory whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subcategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subcategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subcategory whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subcategory whereUpdatedAt($value)
 */
	class Subcategory extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property mixed $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $owner_id
 * @property-read \App\Models\Manager|null $manager
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutRole($roles, $guard = null)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $address
 * @property int $admin_id
 * @property int $created_by
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $admin
 * @method static \Illuminate\Database\Eloquent\Builder|store newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|store newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|store query()
 * @method static \Illuminate\Database\Eloquent\Builder|store whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|store whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|store whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|store whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|store whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|store whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|store whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|store wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|store whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|store whereUpdatedAt($value)
 */
	class store extends \Eloquent {}
}

