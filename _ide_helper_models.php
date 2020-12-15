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
 * App\Models\AcademicClass
 *
 * @property int $id
 * @property string $name
 * @property int $academic_year_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AcademicClassCourse[] $academicClassCourses
 * @property-read int|null $academic_class_courses_count
 * @property-read \App\Models\AcademicYear $academicYear
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicClass newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicClass newQuery()
 * @method static \Illuminate\Database\Query\Builder|AcademicClass onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicClass query()
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicClass whereAcademicYearId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicClass whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicClass whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicClass whereName($value)
 * @method static \Illuminate\Database\Query\Builder|AcademicClass withTrashed()
 * @method static \Illuminate\Database\Query\Builder|AcademicClass withoutTrashed()
 */
	class AcademicClass extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\AcademicClassCourse
 *
 * @property int $id
 * @property string $name
 * @property int $course_id
 * @property int $academic_class_id
 * @property int|null $teacher_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\AcademicClass $academicClass
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Attendance[] $attendances
 * @property-read int|null $attendances_count
 * @property-read \App\Models\Course $course
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AcademicClassCourseStudent[] $students
 * @property-read int|null $students_count
 * @property-read \App\Models\User|null $teacher
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicClassCourse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicClassCourse newQuery()
 * @method static \Illuminate\Database\Query\Builder|AcademicClassCourse onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicClassCourse query()
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicClassCourse whereAcademicClassId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicClassCourse whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicClassCourse whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicClassCourse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicClassCourse whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicClassCourse whereTeacherId($value)
 * @method static \Illuminate\Database\Query\Builder|AcademicClassCourse withTrashed()
 * @method static \Illuminate\Database\Query\Builder|AcademicClassCourse withoutTrashed()
 */
	class AcademicClassCourse extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\AcademicClassCourseStudent
 *
 * @property int $id
 * @property int $number
 * @property int $academic_class_course_id
 * @property int $student_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\AcademicClass $academicClass
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Attendance[] $attendances
 * @property-read int|null $attendances_count
 * @property-read \App\Models\User $student
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicClassCourseStudent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicClassCourseStudent newQuery()
 * @method static \Illuminate\Database\Query\Builder|AcademicClassCourseStudent onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicClassCourseStudent query()
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicClassCourseStudent whereAcademicClassCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicClassCourseStudent whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicClassCourseStudent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicClassCourseStudent whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicClassCourseStudent whereStudentId($value)
 * @method static \Illuminate\Database\Query\Builder|AcademicClassCourseStudent withTrashed()
 * @method static \Illuminate\Database\Query\Builder|AcademicClassCourseStudent withoutTrashed()
 */
	class AcademicClassCourseStudent extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\AcademicYear
 *
 * @property int $id
 * @property string $name
 * @property string $from
 * @property string $to
 * @property int $site_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AcademicClass[] $academicClasses
 * @property-read int|null $academic_classes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Ppdb[] $ppdb
 * @property-read int|null $ppdb_count
 * @property-read \App\Models\Site $site
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicYear newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicYear newQuery()
 * @method static \Illuminate\Database\Query\Builder|AcademicYear onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicYear query()
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicYear whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicYear whereFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicYear whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicYear whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicYear whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicYear whereTo($value)
 * @method static \Illuminate\Database\Query\Builder|AcademicYear withTrashed()
 * @method static \Illuminate\Database\Query\Builder|AcademicYear withoutTrashed()
 */
	class AcademicYear extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Article
 *
 * @property int $id
 * @property string $slug
 * @property string $type
 * @property string|null $title
 * @property string|null $content
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property int|null $site_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $author
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Category[] $categories
 * @property-read int|null $categories_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\App\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \App\Models\Site|null $site
 * @method static \Illuminate\Database\Eloquent\Builder|Article newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Article newQuery()
 * @method static \Illuminate\Database\Query\Builder|Article onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Article query()
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Article withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Article withoutTrashed()
 */
	class Article extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * App\Models\Attendance
 *
 * @property int $id
 * @property string $type
 * @property string $name
 * @property bool $is_open
 * @property \Illuminate\Support\Carbon $started_at
 * @property \Illuminate\Support\Carbon $ended_at
 * @property \Illuminate\Support\Carbon|null $advanced_started_at
 * @property \Illuminate\Support\Carbon|null $advanced_ended_at
 * @property string|null $message
 * @property int $academic_class_course_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\AcademicClassCourse $academicClassCourse
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AcademicClassCourseStudent[] $academicClassCourseStudents
 * @property-read int|null $academic_class_course_students_count
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance newQuery()
 * @method static \Illuminate\Database\Query\Builder|Attendance onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance query()
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereAcademicClassCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereAdvancedEndedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereAdvancedStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereEndedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereIsOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereType($value)
 * @method static \Illuminate\Database\Query\Builder|Attendance withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Attendance withoutTrashed()
 */
	class Attendance extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Category
 *
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property int|null $parent_id
 * @property int|null $site_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Course
 *
 * @property int $id
 * @property string $name
 * @property int $site_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AcademicClass[] $academicClasses
 * @property-read int|null $academic_classes_count
 * @property-read \App\Models\Site $site
 * @method static \Illuminate\Database\Eloquent\Builder|Course newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Course newQuery()
 * @method static \Illuminate\Database\Query\Builder|Course onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Course query()
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereSiteId($value)
 * @method static \Illuminate\Database\Query\Builder|Course withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Course withoutTrashed()
 */
	class Course extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Media
 *
 * @property int $id
 * @property string $model_type
 * @property int $model_id
 * @property string|null $uuid
 * @property int|null $site_id
 * @property int|null $user_id
 * @property string $collection_name
 * @property string $name
 * @property string $file_name
 * @property string|null $mime_type
 * @property string $disk
 * @property string|null $conversions_disk
 * @property int $size
 * @property array $manipulations
 * @property array $custom_properties
 * @property array $responsive_images
 * @property int|null $order_column
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $extension
 * @property-read string $human_readable_size
 * @property-read string $type
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $model
 * @property-read \App\Models\Site|null $site
 * @property-read \App\Models\User|null $user
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|static[] all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|static[] get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Media newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Media newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Media ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|Media query()
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereCollectionName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereConversionsDisk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereCustomProperties($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereDisk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereManipulations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereOrderColumn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereResponsiveImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereUuid($value)
 */
	class Media extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Payment
 *
 * @property int $id
 * @property string|null $provider
 * @property string|null $provider_holder_name
 * @property string|null $provider_number
 * @property string|null $fraud_status
 * @property \Illuminate\Support\Carbon|null $verified_at
 * @property \Illuminate\Support\Carbon|null $paid_on
 * @property int $transaction_id
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\App\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \App\Models\Transaction $transaction
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereFraudStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePaidOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereProviderHolderName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereProviderNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereVerifiedAt($value)
 */
	class Payment extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * App\Models\Ppdb
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon $started_at
 * @property \Illuminate\Support\Carbon $ended_at
 * @property bool $is_open
 * @property int $academic_year_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\AcademicYear $academicYear
 * @property-read \Glorand\Model\Settings\Models\ModelSettings|null $modelSettings
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PpdbUser[] $ppdbUsers
 * @property-read int|null $ppdb_users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Ppdb newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ppdb newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ppdb query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ppdb whereAcademicYearId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ppdb whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ppdb whereEndedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ppdb whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ppdb whereIsOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ppdb whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ppdb whereUpdatedAt($value)
 */
	class Ppdb extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PpdbUser
 *
 * @property int $id
 * @property int $ppdb_id
 * @property int $user_id
 * @property string $selection_method
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Ppdb $ppdb
 * @property-read \App\Models\TransactionItem|null $transactionItem
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TransactionItem[] $transactionItems
 * @property-read int|null $transaction_items_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|PpdbUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PpdbUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PpdbUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|PpdbUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PpdbUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PpdbUser wherePpdbId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PpdbUser whereSelectionMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PpdbUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PpdbUser whereUserId($value)
 */
	class PpdbUser extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ShortLink
 *
 * @property int $id
 * @property string $code
 * @property string $destination
 * @property string|null $title
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ShortLink newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShortLink newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShortLink query()
 * @method static \Illuminate\Database\Eloquent\Builder|ShortLink whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShortLink whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShortLink whereDestination($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShortLink whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShortLink whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShortLink whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShortLink whereUserId($value)
 */
	class ShortLink extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Site
 *
 * @property int $id
 * @property string $domain
 * @property string $title
 * @property string|null $address
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $instagram
 * @property string|null $facebook
 * @property string|null $twitter
 * @property string|null $welcome_message
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AcademicYear[] $academicYears
 * @property-read int|null $academic_years_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Article[] $articles
 * @property-read int|null $articles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Course[] $courses
 * @property-read int|null $courses_count
 * @property-read mixed $logo
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\App\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Glorand\Model\Settings\Models\ModelSettings|null $modelSettings
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Site newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Site newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Site query()
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereDomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereFacebook($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereInstagram($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereTwitter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereWelcomeMessage($value)
 */
	class Site extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * App\Models\Student
 *
 * @property int $id
 * @property string $nis
 * @property string|null $no_kk
 * @property \Illuminate\Support\Carbon|null $accepted_at
 * @property \Illuminate\Support\Carbon|null $declined_at
 * @property \Illuminate\Support\Carbon|null $graduated_at
 * @property string|null $father_name
 * @property string|null $father_phone
 * @property string|null $father_address
 * @property string|null $father_job
 * @property int|null $father_salary
 * @property string|null $mother_name
 * @property string|null $mother_phone
 * @property string|null $mother_address
 * @property string|null $mother_job
 * @property int|null $mother_salary
 * @property string|null $wali_name
 * @property string|null $wali_phone
 * @property string|null $wali_address
 * @property string|null $wali_job
 * @property int|null $wali_salary
 * @property string|null $previous_school
 * @property string|null $previous_school_type
 * @property string|null $previous_school_address
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\App\Models\Media[] $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder|Student newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Student newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Student query()
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereAcceptedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereDeclinedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereFatherAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereFatherJob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereFatherName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereFatherPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereFatherSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereGraduatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereMotherAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereMotherJob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereMotherName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereMotherPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereMotherSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereNis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereNoKk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student wherePreviousSchool($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student wherePreviousSchoolAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student wherePreviousSchoolType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereWaliAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereWaliJob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereWaliName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereWaliPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereWaliSalary($value)
 */
	class Student extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * App\Models\Teacher
 *
 * @property int $id
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher query()
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereId($value)
 */
	class Teacher extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Transaction
 *
 * @property int $id
 * @property string $code
 * @property string $payment_type
 * @property string|null $provider
 * @property string|null $provider_number
 * @property string|null $provider_holder_name
 * @property string|null $redirect_url
 * @property float $amount
 * @property string $status
 * @property \Illuminate\Support\Carbon $valid_until
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Payment|null $payment
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Payment[] $payments
 * @property-read int|null $payments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TransactionItem[] $transactionItems
 * @property-read int|null $transaction_items_count
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction wherePaymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereProviderHolderName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereProviderNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereRedirectUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereValidUntil($value)
 */
	class Transaction extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\TransactionItem
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property int $quantity
 * @property string $itemable_type
 * @property int $itemable_id
 * @property float $price
 * @property int $transaction_id
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $itemable
 * @property-read \App\Models\Transaction $transaction
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionItem whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionItem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionItem whereItemableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionItem whereItemableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionItem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionItem whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionItem whereUpdatedAt($value)
 */
	class TransactionItem extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string|null $nickname
 * @property string|null $email
 * @property string $username
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string $role
 * @property string|null $phone
 * @property string|null $address
 * @property bool $gender
 * @property \Illuminate\Support\Carbon|null $birth_date
 * @property string|null $birth_place
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AcademicClassCourseStudent[] $academicClassCourseStudents
 * @property-read int|null $academic_class_course_students_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Attendance[] $attendances
 * @property-read int|null $attendances_count
 * @property-read mixed $avatar
 * @property-read mixed $photo_url
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\App\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PpdbUser[] $ppdbUsers
 * @property-read int|null $ppdb_users_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Site[] $sites
 * @property-read int|null $sites_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Student[] $studentProfiles
 * @property-read int|null $student_profiles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Teacher[] $teacherProfiles
 * @property-read int|null $teacher_profiles_count
 * @method static \Illuminate\Database\Eloquent\Builder|User acceptedStudents(\App\Models\Site $site)
 * @method static \Illuminate\Database\Eloquent\Builder|User forSite(\App\Models\Site $site = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBirthPlace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 */
	class User extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

