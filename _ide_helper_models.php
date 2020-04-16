<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\Activity
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $transaction_id
 * @property float $amount
 * @property string $description
 * @property string $category
 * @property string $date
 * @property int $recurring
 * @property int $user_id
 * @property int $budget_id
 * @property-read \App\Budget $budget
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereBudgetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereRecurring($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereUserId($value)
 */
	class Activity extends \Eloquent {}
}

namespace App{
/**
 * App\Budget
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $category
 * @property float $planned
 * @property float $actual
 * @property string $year
 * @property string $period
 * @property int $user_id
 * @property string $icon
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Budget newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Budget newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Budget query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Budget whereActual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Budget whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Budget whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Budget whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Budget whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Budget wherePeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Budget wherePlanned($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Budget whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Budget whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Budget whereYear($value)
 */
	class Budget extends \Eloquent {}
}

namespace App{
/**
 * App\Income
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $description
 * @property string $frequency
 * @property float $amount
 * @property int $user_id
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Income newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Income newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Income query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Income whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Income whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Income whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Income whereFrequency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Income whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Income whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Income whereUserId($value)
 */
	class Income extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $api_token
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Budget[] $budgets
 * @property-read int|null $budgets_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Income[] $incomes
 * @property-read int|null $incomes_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereApiToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

