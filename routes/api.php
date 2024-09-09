<?php

use App\Http\Controllers\Api\Admin\CurrencyController;
use App\Http\Controllers\Api\Admin\DistrictController;
use App\Http\Controllers\Api\Admin\FirstLabelController;
use App\Http\Controllers\Api\Admin\LayerController;
use App\Http\Controllers\Api\Admin\PriorityController;
use App\Http\Controllers\Api\Admin\PriorityLayerController;
use App\Http\Controllers\Api\Admin\ProvinceController;
use App\Http\Controllers\Api\Admin\SecondLabelController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\Api\Admin\CityController;
use App\Http\Controllers\Api\Admin\RoleController;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\Admin\LoginController;
use App\Http\Controllers\Api\Admin\NrcNoController;
use App\Http\Controllers\Api\Admin\CountryController;
use App\Http\Controllers\Api\Admin\NrcCodeController;
use App\Http\Controllers\Api\Admin\NrcTypeController;
use App\Http\Controllers\Api\Admin\ProductController;
use App\Http\Controllers\Api\Admin\ZipCodeController;
use App\Http\Controllers\Api\Merchant\AjaxController;
use App\Http\Controllers\Api\Merchant\ShopController;
use App\Http\Controllers\Api\Admin\CategoryController;
use App\Http\Controllers\Api\Admin\HomePageController;
use App\Http\Controllers\Api\Admin\PassportController;
use App\Http\Controllers\Api\Admin\TownshipController;
use App\Http\Controllers\Api\Admin\AboutPageController;
use App\Http\Controllers\Api\Admin\AboutPageMmController;
use App\Http\Controllers\Api\Admin\PostalCodeController;
use App\Http\Controllers\Api\Admin\ContactPageController;
use App\Http\Controllers\Api\Admin\ContactPageMmController;
use App\Http\Controllers\Api\Admin\HomePageMmController;
use App\Http\Controllers\Api\Admin\MaintenanceController;
use App\Http\Controllers\Api\Admin\NrcTownshipController;
use App\Http\Controllers\Api\Admin\ProfilePageController;
use App\Http\Controllers\Api\Admin\ServicePageController;
use App\Http\Controllers\Api\Admin\SubCategoryController;
use App\Http\Controllers\Api\Admin\PassportCodeController;
use App\Http\Controllers\Api\Admin\ProfilePageMmController;
use App\Http\Controllers\Api\Admin\RegionalController;
use App\Http\Controllers\Api\Admin\ServiceAreaController;
use App\Http\Controllers\Api\Admin\ServicePageMmController;
use App\Http\Controllers\Api\Merchant\MerchantLoginController;
use App\Http\Controllers\Api\Merchant\MerchantRegisterController;
use App\Http\Controllers\Api\Merchant\NrcNoController as MerchantNrcNoController;
use App\Http\Controllers\Api\Merchant\ProductController as MerchantProductController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/admin/login', [LoginController::class, 'login']);
Route::post('/admin/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');

Route::post('/merchant/login', [MerchantLoginController::class, 'login']);
Route::post('/merchant/store', [MerchantRegisterController::class, 'store'])->name('merchant.register.store');
Route::post('/merchant/logout', [MerchantLoginController::class, 'logout'])->middleware('auth:sanctum');

Route::post('/service-page', [ServicePageController::class, 'servicePage'])->name('admin.servicePage.index');
Route::post('/profile-page', [ProfilePageController::class, 'profilePage'])->name('admin.profilePage.index');
Route::post('/contact-page', [ContactPageController::class, 'contactPage'])->name('admin.contactPage.index');
Route::post('/home-page', [HomePageController::class, 'homePage'])->name('admin.homePage.index');
Route::post('/about-page', [AboutPageController::class, 'aboutPage'])->name('admin.aboutUsPage.index');

// Maintenance
Route::get('/maintenance', [MaintenanceController::class, 'index'])->name('admin.maintenance.index');


Route::get('/country', [AjaxController::class, 'country'])->name('merchant.townshipCity');
Route::get('/cit', [AjaxController::class, 'cityCountry'])->name('merchant.cityCountry');
Route::get('/township-city/{city}', [AjaxController::class, 'townshipCity'])->name('merchant.townshipCity');


Route::post('store', [MerchantRegisterController::class, 'store'])->name('merchant.register.store');

Route::get('/region-country/{regionId}', [CountryController::class, 'regionCountry'])->name('admin.regionCountry');

Route::get('/division-country/{countryId}',[CountryController::class,'divisionCountry'])->name('admin.divisionCountry');

Route::get('/division-city/{provinceId}',[CountryController::class,'divisionCity'])->name('admin.divisionCity');

Route::get('/city-township/{cityId}',[CountryController::class,'townshipCity'])->name('admin.townshipCity');

Route::get('/country-city/{countryId}', [CountryController::class, 'countryCity'])->name('admin.countryCity');

Route::middleware(['auth:sanctum', 'is_merchant'])->group(function () {
    Route::prefix('merchant')->group(function () {

        // Merchant
        Route::get('/', [MerchantRegisterController::class, 'index'])->name('merchant.register.index');
        Route::post('/update/{id}', [MerchantRegisterController::class, 'update'])->name('merchant.register.update');
        Route::delete('destroy/{id}', [MerchantRegisterController::class, 'destroy'])->name('merchant.register.destory');

        // Shop
        Route::get('/shop', [ShopController::class, 'index'])->name('merchant.shop.index');
        Route::post('/shop/store', [ShopController::class, 'store'])->name('merchant.shop.store');
        Route::put('/shop/update/{id}', [ShopController::class, 'update'])->name('merchant.shop.update');
        Route::delete('/shop/destroy/{id}', [ShopController::class, 'destroy'])->name('merchant.shop.destory');

        // Product
        Route::post('/product/price-list', [MerchantProductController::class, 'product'])->name('merchant.priceList.index');
        Route::post('/product-log', [MerchantProductController::class, 'productLog'])-> name('merchant.productLog');

        // NRC
        Route::get('/nrc-no', [MerchantNrcNoController::class, 'index'])->name('admin.nrcNo.index');
        Route::post('/nrc-no/store', [MerchantNrcNoController::class, 'store'])->name('admin.nrcNo.store');
        Route::put('/nrc-no/update/{id}', [MerchantNrcNoController::class, 'update'])->name('admin.nrcNo.update');


        Route::get('/code-township/{codes}', [AjaxController::class, 'nrcCode'])->name('merchant.codeTownship');

    });
});



Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('admin')->group(function () {

        // Role
        Route::get('/role', [RoleController::class, 'index'])->name('admin.role.index');
        Route::post('/role/store', [RoleController::class, 'store'])->name('admin.role.store');
        Route::put('/role/update/{id}', [RoleController::class, 'update'])->name('admin.role.update');
        Route::delete('/role/destroy/{id}', [RoleController::class, 'destroy'])->name('admin.role.destory');

        Route::get('/users', [UserController::class, 'index'])->name('admin.user.index');
        Route::get('/users/{id}', [UserController::class, 'edit'])->name('admin.user.edit');
        Route::post('/users/store', [UserController::class, 'store'])->name('admin.user.store');
        Route::put('/users/update/{id}', [UserController::class, 'update'])->name('admin.user.update');
        Route::delete('/users/destroy/{id}', [UserController::class, 'destroy'])->name('admin.user.destory');

        // Country
        Route::get('/country/{country}', [CountryController::class, 'index'])->name('admin.country.index');
        Route::get('/country/edit/{id}', [CountryController::class, 'edit'])->name('admin.country.edit');
        Route::post('/country/store', [CountryController::class, 'store'])->name('admin.country.store');
        Route::post('/country/update/{id}', [CountryController::class, 'update'])->name('admin.country.update');
        Route::delete('/country/destroy/{id}', [CountryController::class, 'destroy'])->name('admin.country.destory');

        // City
        Route::get('/city/timezone', [CityController::class, 'timezone'])->name('admin.city.timezone');
        Route::get('/city/{country}', [CityController::class, 'index'])->name('admin.city.index');
        Route::post('/city/store', [CityController::class, 'store'])->name('admin.city.store');
        Route::get('/city/edit/{id}', [CityController::class, 'edit'])->name('admin.city.edit');
        Route::post('/city/update/{id}', [CityController::class, 'update'])->name('admin.city.update');
        Route::delete('/city/destroy/{id}', [CityController::class, 'destroy'])->name('admin.city.destory');
        Route::get('/city-search/{labelId}', [CityController::class, 'citySearch'])->name('admin.citySearch.search');


        // Township
        Route::get('/township/{country}', [TownshipController::class, 'index'])->name('admin.township.index');
        Route::get('/township/edit/{id}', [TownshipController::class, 'edit'])->name('admin.township.edit');
        Route::post('/township/store', [TownshipController::class, 'store'])->name('admin.township.store');
        Route::post('/township/update/{id}', [TownshipController::class, 'update'])->name('admin.township.update');
        Route::delete('/township/destroy/{id}', [TownshipController::class, 'destroy'])->name('admin.township.destory');

        // Postal Code
        Route::get('/postal-code', [PostalCodeController::class, 'index'])->name('admin.postalCode.index');
        Route::post('/postal-code/store', [PostalCodeController::class, 'store'])->name('admin.postalCode.store');
        Route::put('/postal-code/update/{id}', [PostalCodeController::class, 'update'])->name('admin.postalCode.update');
        Route::delete('/postal-code/destroy/{id}', [PostalCodeController::class, 'destroy'])->name('admin.postalCode.destory');

        // Zip Code
        Route::get('/zip-code', [ZipCodeController::class, 'index'])->name('admin.zipCode.index');
        Route::post('/zip-code/store', [ZipCodeController::class, 'store'])->name('admin.zipCode.store');
        Route::put('/zip-code/update/{id}', [ZipCodeController::class, 'update'])->name('admin.zipCode.update');
        Route::delete('/zip-code/destroy/{id}', [ZipCodeController::class, 'destroy'])->name('admin.zipCode.destory');

        // Category
        Route::get('/category/{country}', [CategoryController::class, 'index'])->name('admin.category.index');
        Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('admin.category.edit');
        Route::post('/category/store', [CategoryController::class, 'store'])->name('admin.category.store');
        Route::post('/category/update/{id}', [CategoryController::class, 'update'])->name('admin.category.update');
        Route::delete('/category/destroy/{id}', [CategoryController::class, 'destroy'])->name('admin.category.destory');

        // Sub Category
        Route::get('/sub-category/{country}', [SubCategoryController::class, 'index'])->name('admin.subCategory.index');
        Route::get('/sub-category/edit/{id}', [SubCategoryController::class, 'edit'])->name('admin.subCategory.edit');
        Route::post('/sub-category/store', [SubCategoryController::class, 'store'])->name('admin.subCategory.store');
        Route::post('/sub-category/update/{id}', [SubCategoryController::class, 'update'])->name('admin.subCategory.update');
        Route::delete('/sub-category/destroy/{id}', [SubCategoryController::class, 'destroy'])->name('admin.subCategory.destory');

        // Product *
        Route::get('/product/{country}', [ProductController::class, 'index'])->name('admin.product.index');
        Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('admin.product.edit');
        Route::post('/product/store', [ProductController::class, 'store'])->name('admin.product.store');
        Route::post('/product/update/{id}', [ProductController::class, 'update'])->name('admin.product.update');
        Route::delete('/product/destroy/{id}', [ProductController::class, 'destroy'])->name('admin.product.destory');

        // Service Page
        Route::get('/service-page/{country}', [ServicePageController::class, 'index'])->name('admin.servicePage.index');
        Route::post('/service-page/store', [ServicePageController::class, 'store'])->name('admin.servicePage.store');
        Route::post('/service-page/update/{id}', [ServicePageController::class, 'update'])->name('admin.servicePage.update');
        Route::delete('/service-page/destroy/{id}', [ServicePageController::class, 'destroy'])->name('admin.servicePage.destory');

        // Profile Page
        Route::get('/profile-page/{country}', [ProfilePageController::class, 'index'])->name('admin.profilePage.index');
        Route::post('/profile-page/store', [ProfilePageController::class, 'store'])->name('admin.profilePage.store');
        Route::post('/profile-page/update/{id}', [ProfilePageController::class, 'update'])->name('admin.profilePage.update');
        Route::delete('/profile-page/destroy/{id}', [ProfilePageController::class, 'destroy'])->name('admin.profilePage.destory');

        // Contact Page
        Route::get('/contact-page/{country}', [ContactPageController::class, 'index'])->name('admin.contactPage.index');
        Route::post('/contact-page/store', [ContactPageController::class, 'store'])->name('admin.contactPage.store');
        Route::post('/contact-page/update/{id}', [ContactPageController::class, 'update'])->name('admin.contactPage.update');
        Route::delete('/contact-page/destroy/{id}', [ContactPageController::class, 'destroy'])->name('admin.contactPage.destory');

        // Home Page
        Route::get('/home-page/{country}', [HomePageController::class, 'index'])->name('admin.homePage.index');
        Route::post('/home-page/store', [HomePageController::class, 'store'])->name('admin.homePage.store');
        Route::post('/home-page/update/{id}', [HomePageController::class, 'update'])->name('admin.homePage.update');
        Route::delete('/home-page/destroy/{id}', [HomePageController::class, 'destroy'])->name('admin.homePage.destory');

        // About Page
        Route::get('/about-page/{country}', [AboutPageController::class, 'index'])->name('admin.aboutUsPage.index');
        Route::post('/about-page/store', [AboutPageController::class, 'store'])->name('admin.aboutUsPage.store');
        Route::post('/about-page/update/{id}', [AboutPageController::class, 'update'])->name('admin.aboutUsPage.update');
        Route::delete('/about-page/destroy/{id}', [AboutPageController::class, 'destroy'])->name('admin.aboutUsPage.destory');

        // Service Page Myanmar
        Route::get('/service-page-mm/{country}', [ServicePageMmController::class, 'index'])->name('admin.servicePageMm.index');
        Route::post('/service-page-mm/store', [ServicePageMmController::class, 'store'])->name('admin.servicePageMm.store');
        Route::post('/service-page-mm/update/{id}', [ServicePageMmController::class, 'update'])->name('admin.servicePageMm.update');
        Route::delete('/service-page-mm/destroy/{id}', [ServicePageMmController::class, 'destroy'])->name('admin.servicePageMm.destory');

        // Profile Page Myanmar
        Route::get('/profile-page-mm/{country}', [ProfilePageMmController::class, 'index'])->name('admin.profilePageMm.index');
        Route::post('/profile-page-mm/store', [ProfilePageMmController::class, 'store'])->name('admin.profilePageMm.store');
        Route::post('/profile-page-mm/update/{id}', [ProfilePageMmController::class, 'update'])->name('admin.profilePageMm.update');
        Route::delete('/profile-page-mm/destroy/{id}', [ProfilePageMmController::class, 'destroy'])->name('admin.profilePageMm.destory');

        // Contact Page Myanmar
        Route::get('/contact-page-mm/{country}', [ContactPageMmController::class, 'index'])->name('admin.contactPageMm.index');
        Route::post('/contact-page-mm/store', [ContactPageMmController::class, 'store'])->name('admin.contactPageMm.store');
        Route::post('/contact-page-mm/update/{id}', [ContactPageMmController::class, 'update'])->name('admin.contactPageMm.update');
        Route::delete('/contact-page-mm/destroy/{id}', [ContactPageMmController::class, 'destroy'])->name('admin.contactPageMm.destory');

        // Home Page
        Route::get('/home-page-mm/{country}', [HomePageMmController::class, 'index'])->name('admin.homePageMm.index');
        Route::post('/home-page-mm/store', [HomePageMmController::class, 'store'])->name('admin.homePageMm.store');
        Route::post('/home-page-mm/update/{id}', [HomePageMmController::class, 'update'])->name('admin.homePageMm.update');
        Route::delete('/home-page-mm/destroy/{id}', [HomePageMmController::class, 'destroy'])->name('admin.homePageMm.destory');

        // About Page
        Route::get('/about-page-mm/{country}', [AboutPageMmController::class, 'index'])->name('admin.aboutPageMm.index');
        Route::post('/about-page-mm/store', [AboutPageMmController::class, 'store'])->name('admin.aboutPageMm.store');
        Route::post('/about-page-mm/update/{id}', [AboutPageMmController::class, 'update'])->name('admin.aboutPageMm.update');
        Route::delete('/about-page-mm/destroy/{id}', [AboutPageMmController::class, 'destroy'])->name('admin.aboutPageMm.destory');

        // Passport Code
        Route::get('/passport-code/{country}', [PassportCodeController::class, 'index'])->name('admin.passportCode.index');
        Route::post('/passport-code/store', [PassportCodeController::class, 'store'])->name('admin.passportCode.store');
        Route::put('/passport-code/update/{id}', [PassportCodeController::class, 'update'])->name('admin.passportCode.update');
        Route::delete('/passport-code/destroy/{id}', [PassportCodeController::class, 'destroy'])->name('admin.passportCode.destory');

        // Passport
        Route::get('/passport', [PassportController::class, 'index'])->name('admin.passport.index');
        Route::post('/passport/store', [PassportController::class, 'store'])->name('admin.passport.store');
        Route::put('/passport/update/{id}', [PassportController::class, 'update'])->name('admin.passport.update');
        Route::delete('/passport/destroy/{id}', [PassportController::class, 'destroy'])->name('admin.passport.destory');

        // Nrc Code
        Route::get('/nrc-code/{country}', [NrcCodeController::class, 'index'])->name('admin.nrcCode.index');
        Route::post('/nrc-code/store', [NrcCodeController::class, 'store'])->name('admin.nrcCode.store');
        Route::post('/nrc-code/update/{id}', [NrcCodeController::class, 'update'])->name('admin.nrcCode.update');
        Route::delete('/nrc-code/destroy/{id}', [NrcCodeController::class, 'destroy'])->name('admin.nrcCode.destory');

        // Nrc Township
        Route::get('/nrc-township/{country}', [NrcTownshipController::class, 'index'])->name('admin.nrcTownship.index');
        Route::post('/nrc-township/store', [NrcTownshipController::class, 'store'])->name('admin.nrcTownship.store');
        Route::post('/nrc-township/update/{id}', [NrcTownshipController::class, 'update'])->name('admin.nrcTownship.update');
        Route::delete('/nrc-township/destroy/{id}', [NrcTownshipController::class, 'destroy'])->name('admin.nrcTownship.destory');

        // Nrc Type
        Route::get('/nrc-type/{country}', [NrcTypeController::class, 'index'])->name('admin.nrcType.index');
        Route::post('/nrc-type/store', [NrcTypeController::class, 'store'])->name('admin.nrcType.store');
        Route::put('/nrc-type/update/{id}', [NrcTypeController::class, 'update'])->name('admin.nrcType.update');
        Route::delete('/nrc-type/destroy/{id}', [NrcTypeController::class, 'destroy'])->name('admin.nrcType.destory');

        // Nrc No
        Route::get('/nrc-no', [NrcNoController::class, 'index'])->name('admin.nrcNo.index');
        Route::post('/nrc-no/store', [NrcNoController::class, 'store'])->name('admin.nrcNo.store');
        Route::post('/nrc-no/update/{id}', [NrcNoController::class, 'update'])->name('admin.nrcNo.update');
        // Route::delete('/nrc-no/destroy/{id}', [NrcNoController::class, 'destroy'])->name('admin.nrcNo.destory');

        // Currency
        Route::get('/currency/{country}', [CurrencyController::class, 'index'])->name('admin.currency.index');
        Route::post('/currency/store', [CurrencyController::class, 'store'])->name('admin.currency.store');
        Route::post('/currency/update/{id}', [CurrencyController::class, 'update'])->name('admin.currency.update');
        Route::delete('/currency/destroy/{id}/{country}', [CurrencyController::class, 'destroy'])->name('admin.currency.destory');

        // Regional
        Route::get('/regional/{country}', [RegionalController::class, 'index'])->name('admin.regional.index');
        Route::post('/regional/store', [RegionalController::class, 'store'])->name('admin.regional.store');
        Route::post('/regional/update/{id}', [RegionalController::class, 'update'])->name('admin.regional.update');
        Route::delete('/regional/destroy/{id}', [RegionalController::class, 'destroy'])->name('admin.regional.destory');

        // Service Area
        Route::get('/service-area/{country}', [ServiceAreaController::class, 'index'])->name('admin.serviceArea.index');
        Route::get('/get-serviceArea-countries/{country}/{regional_id}', [ServiceAreaController::class, 'getServiceAreaCountries'])->name('admin.serviceArea.index');
        Route::get('/middle-east/{country}', [ServiceAreaController::class, 'middleEast'])->name('admin.serviceArea.index');
        Route::get('/north-america/{country}', [ServiceAreaController::class, 'northAmerica'])->name('admin.serviceArea.index');
        Route::get('/europe/{country}', [ServiceAreaController::class, 'europe'])->name('admin.serviceArea.index');
        Route::post('/service-area/store', [ServiceAreaController::class, 'store'])->name('admin.serviceArea.store');
        Route::post('/service-area/update/{id}', [ServiceAreaController::class, 'update'])->name('admin.serviceArea.update');
        Route::post('/service-area/delete/{id}', [ServiceAreaController::class, 'delete'])->name('admin.serviceArea.delete');
        Route::delete('/service-area/destroy/{id}', [ServiceAreaController::class, 'destroy'])->name('admin.serviceArea.destory');

        Route::post('/maintenance/store', [MaintenanceController::class, 'store'])->name('admin.maintenance.store');

        // First Label
        Route::get('/first-label/{country}', [FirstLabelController::class, 'index'])->name('admin.firstLabel.index');
        Route::post('/first-label/store', [FirstLabelController::class, 'store'])->name('admin.firstLabel.store');
        Route::post('/first-label/update/{id}', [FirstLabelController::class, 'update'])->name('admin.firstLabel.update');
        Route::delete('/first-label/destroy/{id}', [FirstLabelController::class, 'destroy'])->name('admin.firstLabel.destory');
        Route::get('/first-label-search/{labelId}', [FirstLabelController::class, 'labelSearch'])->name('admin.firstLabelSearch.search');

        // Province
        Route::get('/province/{country}', [ProvinceController::class, 'index'])->name('admin.province.index');
        Route::post('/province/store', [ProvinceController::class, 'store'])->name('admin.province.store');
        Route::post('/province/update/{id}', [ProvinceController::class, 'update'])->name('admin.province.update');
        Route::post('/province-geo/update/{id}', [ProvinceController::class, 'geoUpdate'])->name('admin.provinceGeo.update');
        Route::delete('/province/destroy/{id}', [ProvinceController::class, 'destroy'])->name('admin.province.destory');
        Route::delete('/province-geo/destroy/{id}', [ProvinceController::class, 'geoDestroy'])->name('admin.provinceGeo.destory');
        Route::get('/province-search/{labelId}', [ProvinceController::class, 'provinceSearch'])->name('admin.provinceSearch.search');

        // Second Label
        Route::get('/second-label/{country}', [SecondLabelController::class, 'index'])->name('admin.secondLabel.index');
        Route::post('/second-label/store', [SecondLabelController::class, 'store'])->name('admin.secondLabel.store');
        Route::post('/second-label/update/{id}', [SecondLabelController::class, 'update'])->name('admin.secondLabel.update');
        Route::delete('/second-label/destroy/{id}', [SecondLabelController::class, 'destroy'])->name('admin.secondLabel.destory');

        // Second Label
        Route::get('/district/{country}', [DistrictController::class, 'index'])->name('admin.district.index');
        Route::post('/district/store', [DistrictController::class, 'store'])->name('admin.district.store');
        Route::post('/district/update/{id}', [DistrictController::class, 'update'])->name('admin.district.update');
        Route::delete('/district/destroy/{id}', [DistrictController::class, 'destroy'])->name('admin.district.destory');
        Route::delete('/district-geo/destroy/{id}', [DistrictController::class, 'geoDestroy'])->name('admin.districtGeo.destory');
        Route::post('/district-geo/update/{id}', [DistrictController::class, 'geoUpdate'])->name('admin.districtGeo.update');

        Route::get('/layer/{country}', [LayerController::class, 'index'])->name('admin.layer.index');
        Route::post('/layer/store', [LayerController::class, 'store'])->name('admin.layer.store');
        Route::post('/layer/update/{id}', [LayerController::class, 'update'])->name('admin.layer.update');
        Route::delete('/layer/destroy/{id}', [LayerController::class, 'destroy'])->name('admin.layer.destory');

        Route::get('/priority/{country}', [PriorityController::class, 'index'])->name('admin.priority.index');
        Route::post('/priority/store', [PriorityController::class, 'store'])->name('admin.priority.store');
        Route::post('/priority/update/{id}', [PriorityController::class, 'update'])->name('admin.priority.update');
        Route::delete('/priority/destroy/{id}', [PriorityController::class, 'destroy'])->name('admin.priority.destory');

        Route::get('/priority-layer/{country}', [PriorityLayerController::class, 'index'])->name('admin.prioritylayer.index');
        Route::post('/priority-layer/store', [PriorityLayerController::class, 'store'])->name('admin.prioritylayer.store');
        Route::post('/priority-layer/update/{id}', [PriorityLayerController::class, 'update'])->name('admin.prioritylayer.update');
        Route::delete('/priority-layer/destroy/{id}', [PriorityLayerController::class, 'destroy'])->name('admin.prioritylayer.destory');
    });
});

// Route::fallback(function () {
//     return response()->json(['message' => 'You are not logged in.'], 401);
// });
