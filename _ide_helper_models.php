<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Cancel
 *
 * @property int $id
 * @property int $waiter_id
 * @property string $cancellable_type
 * @property int $cancellable_id
 * @property string $reason
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $cancellable
 * @property-read \App\Models\User $waiter
 * @method static \Illuminate\Database\Eloquent\Builder|Cancel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cancel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cancel query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cancel whereCancellableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cancel whereCancellableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cancel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cancel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cancel whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cancel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cancel whereWaiterId($value)
 */
	class Cancel extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Category
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string $description
 * @property string|null $icon
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Dish> $dishes
 * @property-read int|null $dishes_count
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Configuration
 *
 * @property int $id
 * @property int|null $order_no
 * @property int|null $receipt_no
 * @property string|null $tin_no
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration query()
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereOrderNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereReceiptNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereTinNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereUpdatedAt($value)
 */
	class Configuration extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CustomDish
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Cancel> $cancel
 * @property-read int|null $cancel_count
 * @property-read \App\Models\DiscountedItem|null $discountItem
 * @property-read \App\Models\Order|null $order
 * @method static \Illuminate\Database\Eloquent\Builder|CustomDish newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomDish newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomDish query()
 */
	class CustomDish extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Discount
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Discount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Discount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Discount query()
 */
	class Discount extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DiscountedItem
 *
 * @property-read \App\Models\Discount|null $discountType
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $discountable
 * @method static \Illuminate\Database\Eloquent\Builder|DiscountedItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DiscountedItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DiscountedItem query()
 */
	class DiscountedItem extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Dish
 *
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property string $properties
 * @property float $price
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category $category
 * @property-read mixed $price_formatted
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderDetails> $orderDetails
 * @property-read int|null $order_details_count
 * @method static \Illuminate\Database\Eloquent\Builder|Dish active()
 * @method static \Illuminate\Database\Eloquent\Builder|Dish newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dish newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dish query()
 * @method static \Illuminate\Database\Eloquent\Builder|Dish whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dish whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dish whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dish whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dish wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dish whereProperties($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dish whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dish whereUpdatedAt($value)
 */
	class Dish extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Order
 *
 * @property int $id
 * @property int $waiter_id
 * @property string $order_number
 * @property string $full_name
 * @property string|null $payment_type
 * @property int $checked_out
 * @property \Illuminate\Support\Carbon|null $paid_on
 * @property float|null $total
 * @property float|null $cash
 * @property float|null $change
 * @property int $care_off
 * @property string|null $by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Cancel> $cancel
 * @property-read int|null $cancel_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CustomDish> $customOrderDetails
 * @property-read int|null $custom_order_details_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderDetails> $orderDetails
 * @property-read int|null $order_details_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderReceipt> $orderReceipts
 * @property-read int|null $order_receipts_count
 * @property-read \App\Models\User $waiter
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCareOff($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereChange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCheckedOut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOrderNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaidOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereWaiterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Order withoutTrashed()
 */
	class Order extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OrderDetails
 *
 * @property int $id
 * @property int $order_id
 * @property int $dish_id
 * @property int $pcs
 * @property float $price_per_piece
 * @property float $price
 * @property string|null $note
 * @property string|null $discount_type
 * @property float|null $discount
 * @property float|null $orig_price
 * @property int $printed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Cancel> $cancel
 * @property-read int|null $cancel_count
 * @property-read \App\Models\Dish|null $dish
 * @property-read mixed $price_formatted
 * @property-read \App\Models\Order|null $order
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SideDish> $sideDishes
 * @property-read int|null $side_dishes_count
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetails drinks()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetails newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetails newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetails onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetails query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetails whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetails whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetails whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetails whereDiscountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetails whereDishId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetails whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetails whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetails whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetails whereOrigPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetails wherePcs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetails wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetails wherePricePerPiece($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetails wherePrinted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetails whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetails withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetails withoutTrashed()
 */
	class OrderDetails extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OrderReceipt
 *
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReceipt newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReceipt newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReceipt query()
 */
	class OrderReceipt extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Report
 *
 * @property int $id
 * @property string $date
 * @property float $remitted
 * @property float|null $cash
 * @property float|null $gcash
 * @property float $total_unpaid
 * @property float $late_payments
 * @property float $total_remittance
 * @property float $total_sales
 * @property array|null $spoilages
 * @property array|null $unpaid
 * @property array|null $late
 * @property float|null $total_purchases
 * @property array|null $purchases
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Report newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Report newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Report query()
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereCash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereGcash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereLate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereLatePayments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report wherePurchases($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereRemitted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereSpoilages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereTotalPurchases($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereTotalRemittance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereTotalSales($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereTotalUnpaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereUnpaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereUpdatedAt($value)
 */
	class Report extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Role
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $user
 * @property-read int|null $user_count
 * @method static \Database\Factories\RoleFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SideDish
 *
 * @property-read \App\Models\Dish|null $dish
 * @property-read \App\Models\OrderDetails|null $order
 * @method static \Illuminate\Database\Eloquent\Builder|SideDish newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SideDish newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SideDish query()
 */
	class SideDish extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Table
 *
 * @property int $id
 * @property string $name
 * @property int $pax
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Order> $orders
 * @property-read int|null $orders_count
 * @method static \Illuminate\Database\Eloquent\Builder|Table newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Table newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Table query()
 * @method static \Illuminate\Database\Eloquent\Builder|Table whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Table whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Table whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Table whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Table wherePax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Table whereUpdatedAt($value)
 */
	class Table extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $employee_no
 * @property string $first_name
 * @property string|null $middle_name
 * @property string $last_name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $passcode
 * @property int $role_id
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Cancel> $cancelled
 * @property-read int|null $cancelled_count
 * @property-read mixed $full_name
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Order> $orders
 * @property-read int|null $orders_count
 * @property-read \App\Models\Role|null $role
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmployeeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePasscode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutTrashed()
 */
	class User extends \Eloquent {}
}

