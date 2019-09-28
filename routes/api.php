<?php

use Dingo\Api\Routing\Router;

/** @var Router $api */
$api = app(Router::class);

$api->version('v1', function (Router $api) {
    $api->group(['prefix' => 'auth'], function (Router $api) {
        $api->post('signup', 'App\\Api\\V1\\Controllers\\SignUpController@signUp');
        $api->post('login', 'App\\Api\\V1\\Controllers\\LoginController@login');

        $api->post('recovery', 'App\\Api\\V1\\Controllers\\ForgotPasswordController@sendResetEmail');
        $api->post('reset', 'App\\Api\\V1\\Controllers\\ResetPasswordController@resetPassword');

        $api->post('logout', 'App\\Api\\V1\\Controllers\\LogoutController@logout');
        $api->post('refresh', 'App\\Api\\V1\\Controllers\\RefreshController@refresh');
        $api->get('me', 'App\\Api\\V1\\Controllers\\UserController@me');
    });

    $api->get('hello', function () {
        return response()->json([
            'message' => 'Api is active and is ready to accept requests!!'
        ]);
    });

    $api->group(['middleware' => 'jwt.auth'], function (Router $api) {
        $api->get('refresh', [
            'middleware' => 'jwt.refresh',
            function () {
                return response()->json([
                    'message' => 'By accessing this endpoint, you can refresh your access token at each request. Check out this response headers!'
                ]);
            }
        ]);
        $api->group(['prefix' => 'master'], function (Router $api) {
            $api->group(['prefix' => 'product'], function (Router $api) {
                $api->post('', 'App\\Api\\V1\\Controllers\\Masters\\ProductController@create');
                $api->get('', 'App\\Api\\V1\\Controllers\\Masters\\ProductController@index');
                $api->get('full_list', 'App\\Api\\V1\\Controllers\\Masters\\ProductController@full_index');
                $api->get('{product}', 'App\\Api\\V1\\Controllers\\Masters\\ProductController@show');

            });
        });
        $api->group(['prefix' => 'crm'], function (Router $api) {

            $api->group(['prefix' => 'employee'], function (Router $api) {
                $api->post('', 'App\\Api\\V1\\Controllers\\CRM\\EmployeeController@create');
                $api->post('some-details', 'App\\Api\\V1\\Controllers\\CRM\\EmployeeController@columns');
                $api->get('', 'App\\Api\\V1\\Controllers\\CRM\\EmployeeController@index');
                $api->get('full_list', 'App\\Api\\V1\\Controllers\\CRM\\EmployeeController@full_index');
                $api->get('{employee}', 'App\\Api\\V1\\Controllers\\CRM\\EmployeeController@show');
            });

            $api->group(['prefix' => 'lead'], function (Router $api) {
                $api->post('', 'App\\Api\\V1\\Controllers\\CRM\\LeadController@create');
                $api->get('', 'App\\Api\\V1\\Controllers\\CRM\\LeadController@index');
                $api->get('full_list', 'App\\Api\\V1\\Controllers\\CRM\\LeadController@full_index');
                $api->get('{lead}', 'App\\Api\\V1\\Controllers\\CRM\\LeadController@show');
            });

            $api->group(['prefix' => 'task'], function (Router $api) {
                $api->post('', 'App\\Api\\V1\\Controllers\\CRM\\TaskController@create');
                $api->get('', 'App\\Api\\V1\\Controllers\\CRM\\TaskController@index');
                $api->get('full_list', 'App\\Api\\V1\\Controllers\\CRM\\TaskController@full_index');
                $api->get('{task}', 'App\\Api\\V1\\Controllers\\CRM\\TaskController@show');
                $api->get('markdone/{task}', 'App\\Api\\V1\\Controllers\\CRM\\TaskController@markDone');
            });
        });

        $api->group(['prefix' => 'admin'], function (Router $api) {
            $api->get('app_version', 'App\\Api\\V1\\Controllers\\Masters\\VersionController@get_version');
            /* Companies table*/
            $api->post('company', 'App\\Api\\V1\\Controllers\\Masters\\CompanyController@store');
            $api->post('company_other_details', 'App\\Api\\V1\\Controllers\\Masters\\CompanyController@storeOtherDetails');
            $api->post('setCompany/{id}', 'App\\Api\\V1\\Controllers\\Masters\\CompanyController@setCompany');
            $api->post('company_wizard', 'App\\Api\\V1\\Controllers\\Masters\\CompanyController@createCompanyWizard'); //Create Companies from Wizard
            $api->get('company_list', 'App\\Api\\V1\\Controllers\\Masters\\CompanyController@full_list');
            //Chart of Accounts
            $api->post('coa', 'App\\Api\\V1\\Controllers\\Masters\\ChartAccountsMaster@form');
            $api->get('coa', 'App\\Api\\V1\\Controllers\\Masters\\ChartAccountsMaster@index');
            $api->get('coa_full_list', 'App\\Api\\V1\\Controllers\\Masters\\ChartAccountsMaster@full_list');
            $api->get('coa/{id}', 'App\\Api\\V1\\Controllers\\Masters\\ChartAccountsMaster@show');
            //Godown
            $api->post('godown', 'App\\Api\\V1\\Controllers\\Masters\\GodownMasterController@form');
            $api->get('godown', 'App\\Api\\V1\\Controllers\\Masters\\GodownMasterController@index');
            $api->get('godown_full_list', 'App\\Api\\V1\\Controllers\\Masters\\GodownMasterController@full_list');
            //Bank
            $api->post('bank', 'App\\Api\\V1\\Controllers\\Masters\\BankMasterController@form');
            $api->get('bank', 'App\\Api\\V1\\Controllers\\Masters\\BankMasterController@index');
            $api->get('bank_full_list', 'App\\Api\\V1\\Controllers\\Masters\\BankMasterController@full_list');
            $api->get('bank/{id}', 'App\\Api\\V1\\Controllers\\Masters\\BankMasterController@show');
            //Branch
            $api->post('branch', 'App\\Api\\V1\\Controllers\\Masters\\BranchController@form');
            $api->get('branch', 'App\\Api\\V1\\Controllers\\Masters\\BranchController@index');
            $api->get('branch_full_list', 'App\\Api\\V1\\Controllers\\Masters\\BranchController@full_list');
            $api->get('branch/{id}', 'App\\Api\\V1\\Controllers\\Masters\\BranchController@show');

            //Unit Of Measurement
            $api->post('uom', 'App\\Api\\V1\\Controllers\\Masters\\UnitofMeasurementController@form');
            $api->get('uom', 'App\\Api\\V1\\Controllers\\Masters\\UnitofMeasurementController@index');
            $api->get('uom_full_list', 'App\\Api\\V1\\Controllers\\Masters\\UnitofMeasurementController@full_list');
            $api->get('uom/{id}', 'App\\Api\\V1\\Controllers\\Masters\\UnitofMeasurementController@show');

            //Store Raw Products
            $api->post('raw_product', 'App\\Api\\V1\\Controllers\\Masters\\RawProductController@form');
            $api->get('raw_product', 'App\\Api\\V1\\Controllers\\Masters\\RawProductController@index');
            $api->get('raw_product_full_list', 'App\\Api\\V1\\Controllers\\Masters\\RawProductController@full_list');
            $api->get('raw_product/{id}', 'App\\Api\\V1\\Controllers\\Masters\\RawProductController@show');
            $api->get('raw_product_custom_list', 'App\\Api\\V1\\Controllers\\Masters\\RawProductController@getCustomProductsList');
            /* Attachment table*/
            $api->get('attachment', 'App\\Api\\V1\\Controllers\\AttachmentController@index');
            $api->post('attachment', 'App\\Api\\V1\\Controllers\\AttachmentController@store');
            $api->get('attachment/{id}', 'App\\Api\\V1\\Controllers\\AttachmentController@show');
            $api->delete('attachment/{id}', 'App\\Api\\V1\\Controllers\\AttachmentController@destroy');
            /* Taxes */
            $api->get('tax_full_list', 'App\\Api\\V1\\Controllers\\Masters\\TaxController@full_list');
            /*Product Categories*/
            $api->post('product_category', 'App\\Api\\V1\\Controllers\\Masters\\ProductCategoryController@form');
            $api->get('product_category', 'App\\Api\\V1\\Controllers\\Masters\\ProductCategoryController@index');
            $api->get('product_category_full_list', 'App\\Api\\V1\\Controllers\\Masters\\ProductCategoryController@full_list');
            $api->get('product_category/{id}', 'App\\Api\\V1\\Controllers\\Masters\\ProductCategoryController@show');
            /* Company Operations */

            //BOM
            $api->post('bom', 'App\\Api\\V1\\Controllers\\Masters\\BillOfMaterialMasterController@form');
        });
    });
});
