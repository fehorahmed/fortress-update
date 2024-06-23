<?php

use App\Http\Controllers\AccountsController;
use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\CostingController;
use App\Http\Controllers\ContractorController;
use App\Http\Controllers\ContractorBudgetController;
use App\Http\Controllers\CostingSegmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\EstimateProductController;
use App\Http\Controllers\EstimateProjectController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PhysicalProgressController;
use App\Http\Controllers\ProductSegmentController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PurchaseProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RequisitionController;
use App\Http\Controllers\StakeholderController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\SmsController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoanHolderController;
use App\Http\Controllers\LoanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes(['register' => false, 'reset' => false]);

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('access_permission_role',  [UserController::class,'accessPermissionRole'])->name('access_permission_role');

    //Auth::routes();
    Route::middleware(['custom:3'])->group(function () {

    // User Management
    Route::get('user', [UserController::class,'index'])->name('user.all');
    Route::get('user/add',  [UserController::class,'add'])->name('user.add');
    Route::post('user/add',  [UserController::class,'addPost']);
    Route::get('user/edit/{user}',  [UserController::class,'edit'])->name('user.edit');
    Route::post('user/edit/{user}',  [UserController::class,'editPost']);


    // Project Management
    Route::get('project', [ProjectController::class,'index'])->name('project.all');
    Route::get('project/add',  [ProjectController::class,'add'])->name('project.add');
    Route::post('project/add',  [ProjectController::class,'addPost']);
    Route::get('project/edit/{project}',  [ProjectController::class,'edit'])->name('project.edit');
    Route::post('project/edit/{project}',  [ProjectController::class,'editPost']);
    Route::get('project-datatable', [ProjectController::class,'datatable'])->name('project.datatable');

    });

    Route::middleware(['custom:1'])->group(function () {
        //Stakeholder View
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::get('/home-documentation', [HomeController::class, 'documentation'])->name('stakeholder.documentation');
        Route::get('/home-documentation/details/{documentation}', [HomeController::class, 'documentationDetails'])->name('stakeholder.documentation.details');
        Route::get('/home-gallery', [HomeController::class, 'gallery'])->name('stakeholder.gallery');
        Route::get('/home-payments', [HomeController::class, 'payment'])->name('stakeholder.view.payment');
        Route::get('/home-project', [HomeController::class, 'project'])->name('stakeholder.project');
        Route::get('/home-project-progress', [HomeController::class, 'projectProgress'])->name('stakeholder.project.progress');

    });

    Route::middleware(['custom:2'])->group(function () {
        // Warehouse
        Route::get('warehouse', [WarehouseController::class,'index'])->name('warehouse.all')->middleware('permission:warehouses');
        Route::get('warehouse/add', [WarehouseController::class,'add'])->name('warehouse.add')->middleware('permission:warehouses');
        Route::post('warehouse/add', [WarehouseController::class,'addPost'])->middleware('permission:warehouses');
        Route::get('warehouse/edit/{warehouse}', [WarehouseController::class,'edit'])->name('warehouse.edit')->middleware('permission:warehouses');
        Route::post('warehouse/edit/{warehouse}', [WarehouseController::class,'editPost'])->middleware('permission:warehouses');
        Route::get('warehouse/datatable', [WarehouseController::class,'datatable'])->name('warehouse.datatable')->middleware('permission:warehouses');

        // Unit
        Route::get('unit', [UnitController::class,'index'])->name('unit.all')->middleware('permission:units');
        Route::get('unit/add',[UnitController::class,'add'])->name('unit.add')->middleware('permission:units');
        Route::post('unit/add', [UnitController::class,'addPost'])->middleware('permission:units');
        Route::get('unit/edit/{unit}', [UnitController::class,'edit'])->name('unit.edit')->middleware('permission:units');
        Route::post('unit/edit/{unit}', [UnitController::class,'editPost'])->middleware('permission:units');
        Route::get('unit/datatable', [UnitController::class,'datatable'])->name('unit.datatable')->middleware('permission:units');

        // StakeHolder
        Route::get('stakeholder/projects', [StakeholderController::class,'showProjects'])->name('stakeholder.projects')->middleware('permission:stakeholders');
        Route::get('stakeholders/{project}', [StakeholderController::class,'index'])->name('stakeholder.all')->middleware('permission:stakeholders');
        Route::get('stakeholder/add',[StakeholderController::class,'add'])->name('stakeholder.add')->middleware('permission:stakeholders');
        Route::post('stakeholder/add', [StakeholderController::class,'addPost']);
        Route::get('stakeholder/edit/{stakeholder}', [StakeholderController::class,'edit'])->name('stakeholder.edit')->middleware('permission:stakeholders');
        Route::post('stakeholder/edit/{stakeholder}', [StakeholderController::class,'editPost'])->middleware('permission:stakeholders');
        Route::get('stakeholder/datatable', [StakeholderController::class,'datatable'])->name('stakeholder.datatable')->middleware('permission:stakeholders');


        Route::get('stakeholder/payment', [StakeholderController::class,'stakeholderPayment'])->name('stakeholder.payment')->middleware('permission:stakeholder_payment');
        Route::get('stakeholder/payment-datatable', [StakeholderController::class,'stakeholderPaymentDatatable'])->name('stakeholder.payment.datatable')->middleware('permission:stakeholder_payment');
        Route::get('stakeholder-payment/get-projects',  [StakeholderController::class,'stakeholderPaymentGetProjects'])->name('stakeholder_payment.get_projects')->middleware('permission:stakeholder_payment');
        Route::get('stakeholder-payment/project-wise-stakeholder',  [StakeholderController::class,'getProjectWiseStakeholderDetails'])->name('get_project_wise_stakeholder_details')->middleware('permission:stakeholder_payment');
        Route::post('stakeholder-payment/payment',  [StakeholderController::class,'stakeholderMakePayment'])->name('stakeholder_payment.make_payment')->middleware('permission:stakeholder_payment');
        Route::get('stakeholder-payment/payment-details/{stakeholder}',  [StakeholderController::class,'paymentDetailsByStakeholder'])->name('payment_details_by_stakeholder')->middleware('permission:stakeholder_payment');
        Route::get('stakeholder-payment/payment-edit/{stakeholderPayment}',  [StakeholderController::class,'paymentDetailsEdit'])->name('stakeholder.payment_receipt.edit')->middleware('permission:stakeholder_payment');
        Route::post('stakeholder-payment/payment-edit/{stakeholderPayment}',  [StakeholderController::class,'paymentDetailsEditPost'])->middleware('permission:stakeholder_payment');
        // Route::post('stakeholder-payment/payment-edit/{id}',  [StakeholderController::class,'paymentDetailsEditPost'])->middleware('permission:stakeholder_payment');
        Route::get('stakeholder-payment-details/print/{stakeholder}',  [StakeholderController::class,'paymentDetailsPrint'])->name('payment_details.print')->middleware('permission:stakeholder_payment');
        Route::get('stakeholder-payment/payment-receipt/{payment}',  [StakeholderController::class,'paymentReceipt'])->name('stakeholder.payment_receipt')->middleware('permission:stakeholder_payment');

        //Budget & Profit distribute
        Route::get('project-budget-distribute', [ProjectController::class,'budgetDistribute'])->name('budget.distribute')->middleware('permission:budget_distribution');
        // Account Head Type
        Route::get('account-head/type', [AccountsController::class,'accountHeadType'])->name('account_head.type')->middleware('permission:account_head_type');
        Route::get('account-head/type/add',  [AccountsController::class,'accountHeadTypeAdd'])->name('account_head.type.add')->middleware('permission:account_head_type');
        Route::post('account-head/type/add', [AccountsController::class,'accountHeadTypeAddPost'])->middleware('permission:account_head_type');
        Route::get('account-head/type/edit/{type}', [AccountsController::class,'accountHeadTypeEdit'])->name('account_head.type.edit')->middleware('permission:account_head_type');
        Route::post('account-head/type/edit/{type}', [AccountsController::class,'accountHeadTypeEditPost'])->middleware('permission:account_head_type');

        // Account Head Sub Type
        Route::get('account-head/sub-type', [AccountsController::class,'accountHeadSubType'])->name('account_head.sub_type')->middleware('permission:account_sub_head_type');
        Route::get('account-head/sub-type/add', [AccountsController::class,'accountHeadSubTypeAdd'])->name('account_head.sub_type.add')->middleware('permission:account_sub_head_type');
        Route::post('account-head/sub-type/add', [AccountsController::class,'accountHeadSubTypeAddPost'])->middleware('permission:account_sub_head_type');
        Route::get('account-head/sub-type/edit/{subType}', [AccountsController::class,'accountHeadSubTypeEdit'])->name('account_head.sub_type.edit')->middleware('permission:account_sub_head_type');
        Route::post('account-head/sub-type/edit/{subType}', [AccountsController::class,'accountHeadSubTypeEditPost'])->middleware('permission:account_sub_head_type');


        // Bank
        Route::get('bank', [BankController::class,'index'])->name('bank')->middleware('permission:bank');
        Route::get('bank/add', [BankController::class,'add'])->name('bank.add')->middleware('permission:bank');
        Route::post('bank/add', [BankController::class,'addPost'])->middleware('permission:bank');
        Route::get('bank/edit/{bank}', [BankController::class,'edit'])->name('bank.edit')->middleware('permission:bank');
        Route::post('bank/edit/{bank}', [BankController::class,'editPost'])->middleware('permission:bank');

        // Bank Branch
        Route::get('bank-branch', [BranchController::class,'index'])->name('branch')->middleware('permission:branch');
        Route::get('bank-branch/add', [BranchController::class,'add'])->name('branch.add')->middleware('permission:branch');
        Route::post('bank-branch/add', [BranchController::class,'addPost'])->middleware('permission:branch');
        Route::get('bank-branch/edit/{branch}', [BranchController::class,'edit'])->name('branch.edit')->middleware('permission:branch');
        Route::post('bank-branch/edit/{branch}', [BranchController::class,'editPost'])->middleware('permission:branch');

        // Bank account
        Route::get('bank-account', [BankAccountController::class,'index'])->name('bank_account')->middleware('permission:account');
        Route::get('bank-account/add', [BankAccountController::class,'add'])->name('bank_account.add')->middleware('permission:account');
        Route::post('bank-account/add', [BankAccountController::class,'addPost'])->middleware('permission:account');
        Route::get('bank-account/edit/{account}', [BankAccountController::class,'edit'])->name('bank_account.edit')->middleware('permission:account');
        Route::post('bank-account/edit/{account}', [BankAccountController::class,'editPost'])->middleware('permission:account');
        Route::get('bank-account/get-branches', [BankAccountController::class,'getBranches'])->name('bank_account.get_branch');



        // Transaction
        //  Route::get('transaction', 'AccountsController@transactionIndex')->name('transaction.all');
        Route::get('transaction/project/wise', [AccountsController::class,'transactionProjectwise'])->name('transaction.project_wise')->middleware('permission:project_wise_transaction');
        Route::get('transaction/project/wise/add', [AccountsController::class,'transactionProjectwiseAdd'])->name('transaction.project_wise.add')->middleware('permission:project_wise_transaction');
        Route::post('transaction/project/wise/add', [AccountsController::class,'transactionProjectwiseAddPost'])->middleware('permission:project_wise_transaction');
        Route::get('transaction/project-wise/datatable', [AccountsController::class,'projectWiseDatatable'])->name('projectWise.datatable')->middleware('permission:project_wise_transaction');

        Route::get('transaction/delete/{id}', 'AccountsController@transactionDelete')->name('transaction.delete');
        Route::get('transaction/project-wise-edit/{transaction}', [AccountsController::class,'transactionProjectWiseEdit'])->name('transaction.project_wise.edit')->middleware('permission:project_wise_transaction');
        Route::post('transaction/project-wise-edit/{transaction}', [AccountsController::class,'transactionProjectWiseEditPost'])->middleware('permission:project_wise_transaction');
        Route::get('transaction/print/{transaction}', [AccountsController::class,'transactionPrint'])->name('transaction.print')->middleware('permission:project_wise_transaction');
        Route::get('report/transaction', [AccountsController::class,'reportTransaction'])->name('report.transaction');

        //SMS
        Route::get('sms/template', [SmsController::class,'smsTemplate'])->name('sms.template');
        Route::get('sms/template/add', [SmsController::class,'smsTemplateAdd'])->name('sms.template.add');
        Route::post('sms/template/add', [SmsController::class,'smsTemplateAddPost']);
        Route::get('sms/template/edit/{smsTemplate}', [SmsController::class,'smsTemplateEdit'])->name('sms.template.edit');
        Route::post('sms/template/edit/{smsTemplate}', [SmsController::class,'smsTemplateEditPost']);
        Route::get('sms/log', [SmsController::class,'smsLog'])->name('sms.log');
        Route::get('sms/sent', [SmsController::class,'smsSent'])->name('sms.sent');
        Route::get('sms/send/stakeholder', [SmsController::class,'sendMessageToStakeholder'])->name('sms.send.stakeholder');

        // Balance Transfer
        Route::get('balance-transfer', [AccountsController::class,'balanceTransfer'])->name('balance_transfer.all')->middleware('permission:balance_transfer');
        Route::get('balance-transfer/datatable', [AccountsController::class,'balanceTransferDatatable'])->name('balance_transfer.datatable')->middleware('permission:balance_transfer');
        Route::get('balance-transfer/add', [AccountsController::class,'balanceTransferAdd'])->name('balance_transfer.add')->middleware('permission:balance_transfer');
        Route::post('balance-transfer/add', [AccountsController::class,'balanceTransferAddPost'])->middleware('permission:balance_transfer');
        Route::get('balance-transfer/edit/{id}', [AccountsController::class,'balanceTransferEdit'])->name('balance_transfer.edit')->middleware('permission:balance_transfer');
        Route::post('balance-transfer/edit/{id}', [AccountsController::class,'balanceTransferEditPost'])->middleware('permission:balance_transfer');
        Route::get('balance-transfer/print/{transfer}', [AccountsController::class,'transferPrint'])->name('transfer.print')->middleware('permission:balance_transfer');
        Route::get('balance-transfer/delete/{id}', 'AccountsController@balanceTransferDelete')->name('balance_transfer.delete')->middleware('permission:balance_transfer');



        // Purchase Product
        Route::get('purchase-product', [PurchaseProductController::class,'index'])->name('purchase_product')->middleware('permission:product');
        Route::get('purchase-product/add', [PurchaseProductController::class,'add'])->name('purchase_product.add')->middleware('permission:product');
        Route::post('purchase-product/add', [PurchaseProductController::class,'addPost'])->middleware('permission:product');
        Route::get('purchase-product/edit/{product}', [PurchaseProductController::class,'edit'])->name('purchase_product.edit')->middleware('permission:product');
        Route::post('purchase-product/edit/{product}', [PurchaseProductController::class,'editPost'])->middleware('permission:product');

        // product excel import export
        Route::get('product/import', [PurchaseProductController::class,'productImport'])->name('product.import');
        Route::post('product/import', [PurchaseProductController::class,'productImportPost']);

        // Product Segment
        Route::get('product-segment-projects', [ProductSegmentController::class,'segmentProjects'])->name('segment.projects')->middleware('permission:segment');
        Route::get('product-segment/{project}', [ProductSegmentController::class,'index'])->name('segment')->middleware('permission:segment');
        Route::get('product-segment/add/segment', [ProductSegmentController::class,'segmentAdd'])->name('segment.project.add')->middleware('permission:segment');
        Route::post('product-segment/add/segment', [ProductSegmentController::class,'addPost'])->middleware('permission:segment');
        Route::get('product-segment/edit/{segment}', [ProductSegmentController::class,'edit'])->name('segment.edit')->middleware('permission:segment');
        Route::post('product-segment/edit/{segment}', [ProductSegmentController::class,'editPost'])->middleware('permission:segment');

        // Physical Progress
        Route::get('physical-progress', [PhysicalProgressController::class,'index'])->name('physical.project.all')->middleware('permission:physical_progress_add');
        Route::get('physical-progress/add', [PhysicalProgressController::class,'add'])->name('physical_progress.add')->middleware('permission:physical_progress_add');
        Route::post('physical-progress/add', [PhysicalProgressController::class,'addPost'])->middleware('permission:physical_progress_add')->middleware('permission:physical_progress_add');
        Route::get('physical-progress/view/{project}', [PhysicalProgressController::class,'projectWiseView'])->name('physical_progress_view')->middleware('permission:physical_progress_add');
        Route::get('project-progress-datatable', [PhysicalProgressController::class,'progressDatatable'])->name('physical_progress.project.datatable')->middleware('permission:physical_progress_add');
        Route::get('physical-progress-report', [PhysicalProgressController::class,'report'])->name('physical.project.report')->middleware('permission:physical_progress_report');

        // Project duration
        Route::get('project-duration', [ProjectController::class,'duration'])->name('duration')->middleware('permission:project_duration');
        Route::get('budget/add', [ProjectController::class,'budgetAdd'])->name('budget.add')->middleware('permission:project_duration');
        Route::post('budget/add', [ProjectController::class,'budgetAddPost'])->middleware('permission:project_duration');
        Route::get('project-duration/edit/{budget}', [ProjectController::class,'durationEdit'])->name('duration.edit')->middleware('permission:project_duration');
        Route::post('project-duration/edit/{budget}', [ProjectController::class,'durationEditPost'])->middleware('permission:project_duration');

        // Project budget
        Route::get('project-installment', [ProjectController::class,'installment'])->name('project.installment')->middleware('permission:project_budget');
        Route::get('project-installment/edit/{project}', [ProjectController::class,'installmentEdit'])->name('project.installment.edit')->middleware('permission:project_budget');
        Route::post('project-installment/edit/{project}', [ProjectController::class,'installmentEditPost'])->middleware('permission:project_budget');

        // Project  Documentation
        Route::get('project-info-all', [DocumentationController::class,'index'])->name('documentation.project.all')->middleware('permission:documentation_info');
        Route::get('project-info-all/add/{project}', [DocumentationController::class,'add'])->name('documentation.project.add')->middleware('permission:documentation_info');
        Route::post('project-info-all/add/{project}', [DocumentationController::class,'addPost'])->middleware('permission:documentation_info');
        Route::get('project-info-all/edit/{info}', [DocumentationController::class,'edit'])->name('documentation.project.edit')->middleware('permission:documentation_info');
        Route::post('project-info-all/edit/{info}', [DocumentationController::class,'editPost'])->middleware('permission:documentation_info');
        Route::get('project-view-all/{project}', [DocumentationController::class,'projectView'])->name('documentation.project.view')->middleware('permission:documentation_info');

        Route::get('project-galary-all', [DocumentationController::class,'gallaryAll'])->name('project.galary.all')->middleware('permission:project_gallery');
        Route::get('project-gallary-view/{project}', [DocumentationController::class,'gallaryViewAdd'])->name('project.gallary.view')->middleware('permission:project_gallery');
        Route::post('project-gallary-add/{project}', [DocumentationController::class,'gallaryAdd'])->name('project.gallary.add')->middleware('permission:project_gallery');
        Route::get('project-gallary-delete/{gallery}', [DocumentationController::class,'gallaryDelete'])->name('project.gallary.delete')->middleware('permission:project_gallery');

        // create Estimating And Costing

        Route::get('costing/projects', [CostingController::class,'allProjects'])->name('costing.projects')->middleware('permission:all_boq_costing');
        Route::get('costing/{project}', [CostingController::class,'index'])->name('costing')->middleware('permission:all_boq_costing');
        Route::get('costing/{project}', [CostingController::class,'index'])->name('costing')->middleware('permission:all_boq_costing');
        Route::get('costing/add/costing',[CostingController::class,'add'])->name('costing.add')->middleware('permission:all_boq_costing');
        Route::post('costing/add/costing', [CostingController::class,'addPost'])->middleware('permission:all_boq_costing');
        Route::get('costing/edit/{costing}', [CostingController::class,'edit'])->name('costing.edit')->middleware('permission:all_boq_costing');
        Route::post('costing/edit/{costing}', [CostingController::class,'editPost'])->middleware('permission:all_boq_costing');
        Route::get('costing-datatable', [CostingController::class,'costingDatatable'])->name('costing.datatable')->middleware('permission:all_boq_costing');

        Route::get('costing-details/{costing}', [CostingController::class,'details'])->name('costing.details')->middleware('permission:all_boq_costing');
        //   Route::get('costing-report-details/{costing}', [CostingController::class,'reportDetails'])->name('costing_report.details')->middleware('permission:boq_report');
        Route::get('estimate-product-json', [CostingController::class,'estimateProductJson'])->name('estimate_product.json');
        Route::get('estimate-product-json-edit', [CostingController::class,'estimateProductJsonEdit'])->name('estimate_product.json.edit');
        Route::get('estimate-product-details', [CostingController::class,'estimateProductDetails'])->name('estimate_product.details')->middleware('permission:all_boq_costing');
        Route::get('costing/project/report', [CostingController::class,'costingReport'])->name('costing_report')->middleware('permission:boq_report');


        //boq_edit
        Route::get('boq-edit',[RequisitionController::class,'index'])->name('boq_edit')->middleware('permission:requisitions');
        Route::get('boq-view/{project}',[RequisitionController::class,'requisitionSegmentView'])->name('segment.view')->middleware('permission:requisitions');
        Route::get('requisition/edit/{costing}', [RequisitionController::class,'edit'])->name('requisition.edit')->middleware('permission:requisitions');
        Route::post('requisition/edit/{costing}', [RequisitionController::class,'editPost'])->middleware('permission:requisitions');
        Route::get('requisition-details/{requisition}', [RequisitionController::class,'details'])->name('requisition.details')->middleware('permission:requisitions');
        Route::get('estimate-view-project-datatable', [RequisitionController::class,'requisitionViewDatatable'])->name('estimate_project.view.datatable')->middleware('permission:requisitions');
        Route::get('requisition-datatable', [RequisitionController::class,'requisitionDatatable'])->name('requisition.datatable')->middleware('permission:requisitions');

        //Requisition
        Route::get('requisition/{costing}', [RequisitionController::class,'all'])->name('requisition')->middleware('permission:requisitions');
        Route::get('requisition/add/{costing}', [RequisitionController::class,'add'])->name('requisition.add')->middleware('permission:requisitions');
        Route::post('requisition/add/{costing}', [RequisitionController::class,'addPost'])->middleware('permission:requisitions');
        //Permission by Warehouse
        Route::get('requisition/view/edit/{requisition}', [RequisitionController::class,'viewEdit'])->name('requisition.view.edit')->middleware('permission:warehouses');
        Route::post('requisition/view/edit/{requisition}', [RequisitionController::class,'viewEditPost'])->middleware('permission:warehouses');
        Route::get('requisition/project/report', [RequisitionController::class,'requisitionReport'])->name('requisition.project.report')->middleware('permission:requisition_report');

        // Supplier
        Route::get('supplier', [SupplierController::class,'index'])->name('supplier')->middleware('permission:supplier');
        Route::get('supplier/add',  [SupplierController::class,'add'])->name('supplier.add')->middleware('permission:supplier');
        Route::post('supplier/add',  [SupplierController::class,'addPost'])->middleware('permission:supplier');
        Route::get('supplier/edit/{supplier}',  [SupplierController::class,'edit'])->name('supplier.edit')->middleware('permission:supplier');
        Route::post('supplier/edit/{supplier}',  [SupplierController::class,'editPost'])->middleware('permission:supplier');

        // Contactor
        Route::get('contractor', [ContractorController::class,'index'])->name('contractor');
        Route::get('contractor/add',  [ContractorController::class,'add'])->name('contractor.add');
        Route::post('contractor/add',  [ContractorController::class,'addPost']);
        Route::get('contractor/edit/{contractor}',  [ContractorController::class,'edit'])->name('contractor.edit');
        Route::post('contractor/edit/{contractor}',  [ContractorController::class,'editPost']);

        // Contactor Budget
        Route::get('contractor_budget', [ContractorBudgetController::class,'index'])->name('contractor_budget');
        Route::get('contractor_budget/add',  [ContractorBudgetController::class,'add'])->name('contractor_budget.add');
        Route::post('contractor_budget/add',  [ContractorBudgetController::class,'addPost']);
        Route::get('contractor_budget/edit/{contractorBudget}',  [ContractorBudgetController::class,'edit'])->name('contractor_budget.edit');
        Route::post('contractor_budget/edit/{contractorBudget}',  [ContractorBudgetController::class,'editPost']);

        // Purchase
        Route::get('purchase', [PurchaseController::class,'purchaseOrder'])->name('purchase_order.create')->middleware('permission:purchase');
        Route::post('purchase', [PurchaseController::class,'purchaseOrderPost'])->middleware('permission:purchase');
        Route::get('purchase-product-json', [PurchaseController::class,'purchaseProductJson'])->name('purchase_product.json')->middleware('permission:purchase');
        Route::post('purchase-order-receive', [PurchaseController::class,'purchaseProductReceive'])->name('purchase_order_receive')->middleware('permission:purchase');


        //Holder loan section
        Route::get('loan/all',[LoanController::class,'Index'])->name('loan.all');
        Route::get('loan/create',[LoanController::class,'Create'])->name('loan.add');
        Route::post('loan/create',[LoanController::class,'loanStore']);
        Route::get('loan/edit/{loan}',[LoanController::class,'edit'])->name('loan.edit');
        Route::post('loan/edit/{loan}',[LoanController::class,'editPost']);
        Route::get('loan/datatable',[LoanController::class,'loanDatatable'])->name('loan.datatable');
        Route::get('loan-details/{loanHolder}/{type}',[LoanController::class,'loanDetails'])->name('loan_details');
        Route::get('loan-payment/get-orders',[LoanController::class,'loanPaymentGetNumber'])->name('loan_payment.get_number');
        Route::get('loan-payment/order-details',[LoanController::class,'loanPaymentOrderDetails'])->name('loan_payment.order_details');
        Route::post('loan-payment/payment',[LoanController::class,'makePayment'])->name('loan_payment.make_payment');
        Route::get('loan-payment-details/{loan}/{type}',[LoanController::class,'loanPaymentDetails'])->name('loan_payment_details');
        Route::get('loan-payment-print/{payment}',[LoanController::class,'loanPaymentPrint'])->name('loan_payment_print');

        //loan holder
        Route::get('loan-holder', [LoanHolderController::class, 'index'])->name('loan_holder');
        Route::get('loan-holder/add',[LoanHolderController::class,'add'])->name('loan_holder.add');
        Route::post('loan-holder/add',[LoanHolderController::class,'addPost']);
        Route::get('loan-holder/edit/{loanHolder}',[LoanHolderController::class,'edit'])->name('loan_holder.edit');
        Route::post('loan-holder/edit/{loanHolder}',[LoanHolderController::class,'editPost']);


        // Purchase Receipt
        Route::get('purchase-projects', [PurchaseController::class,'purchaseProjects'])->name('purchase_projects')->middleware('permission:purchase_receipt');
        Route::get('purchase-receipt', [PurchaseController::class,'purchaseReceipt'])->name('purchase_receipt.all')->middleware('permission:purchase_receipt');
        Route::get('purchase-receive/details/{order}', [PurchaseController::class,'purchaseReceiveDetails'])->name('purchase_receive.details')->middleware('permission:purchase_receipt');
        Route::get('purchase-receipt/details/{order}', [PurchaseController::class,'purchaseReceiptDetails'])->name('purchase_receipt.details')->middleware('permission:purchase_receipt');
        Route::get('purchase-receipt/datatable', [PurchaseController::class,'receiptProjectsDatatable'])->name('receipt_projects.datatable')->middleware('permission:purchase_receipt');
        Route::get('purchase-receipt/datatable', [PurchaseController::class,'purchaseReceiptDatatable'])->name('purchase_receipt.datatable')->middleware('permission:purchase_receipt');
        Route::get('purchase-receipt/payment/details/{payment}', [PurchaseController::class,'purchasePaymentDetails'])->name('purchase_receipt.payment_details')->middleware('permission:supplier_payment');
        Route::get('purchase-receipt/payment/edit/{payment}', [PurchaseController::class,'purchasePaymentEdit'])->name('purchase_receipt.payment_edit')->middleware('permission:supplier_payment');
        Route::post('purchase-receipt/payment/edit/{payment}', [PurchaseController::class,'purchasePaymentEditPost'])->middleware('permission:supplier_payment');
        Route::get('purchase-receipt/payment/print/{payment}', [PurchaseController::class,'purchasePaymentPrint'])->name('purchase_receipt.payment_print')->middleware('permission:purchase_receipt');

        // Supplier Payment
        Route::get('supplier-payment', [PurchaseController::class,'supplierPayment'])->name('supplier_payment.all')->middleware('permission:supplier_payment');
        Route::get('supplier-payment-details/{supplier}', [PurchaseController::class,'supplierPaymentDetails'])->name('supplier_payment_details')->middleware('permission:supplier_payment');
        Route::get('supplier-payment/get-orders',  [PurchaseController::class,'supplierPaymentGetOrders'])->name('supplier_payment.get_orders')->middleware('permission:supplier_payment');
        Route::get('supplier-payment/get-refund-orders',  [PurchaseController::class,'supplierPaymentGetRefundOrders'])->name('supplier_payment.get_refund_orders')->middleware('permission:supplier_payment');
        Route::get('supplier-payment/order-details',  [PurchaseController::class,'supplierPaymentOrderDetails'])->name('supplier_payment.order_details')->middleware('permission:supplier_payment');
        Route::post('supplier-payment/payment',  [PurchaseController::class,'makePayment'])->name('supplier_payment.make_payment')->middleware('permission:supplier_payment');
        Route::post('supplier-payment/refund',  [PurchaseController::class,'makeRefund'])->name('supplier_payment.make_refund')->middleware('permission:supplier_payment');

        // Contractor Payment
        Route::get('contractor-payment', [ContractorController::class,'contractorPayment'])->name('contractor_payment.all');
        Route::get('contractor-payment-details/{contractor}', [ContractorController::class,'contractorPaymentAll'])->name('contractor_payment_details');
        Route::get('contractor-payment/get-orders',  [ContractorController::class,'contractorPaymentGetOrders'])->name('contractor_payment.get_orders');
        Route::get('contractor-payment/get-refund-orders',  [ContractorController::class,'contractorPaymentGetRefundOrders'])->name('contractor_payment.get_refund_orders');
        Route::get('contractor-payment/order-details',  [ContractorController::class,'contractorPaymentOrderDetails'])->name('contractor_payment.order_details');
        Route::post('contractor-payment/payment',  [ContractorController::class,'makePayment'])->name('contractor_payment.make_payment');
        Route::post('contractor-payment/refund',  [ContractorController::class,'makeRefund'])->name('contractor_payment.make_refund');

        //Contractor Payment Details
        Route::get('contractor-receipt/payment/details/{payment}', [ContractorController::class,'contractorPaymentDetails'])->name('contractor_receipt.payment_details');
        Route::get('contractor-receipt/payment/print/{payment}', [ContractorController::class,'contractorPaymentPrint'])->name('contractor_receipt.payment_print');
        Route::get('contractor-receipt/payment/edit/{payment}', [ContractorController::class,'contractorPaymentEdit'])->name('contractor_receipt.payment_edit');
        Route::post('contractor-receipt/payment/edit/{payment}', [ContractorController::class,'contractorPaymentEditPost']);


        // Purchase Inventory
        Route::get('purchase-inventory/{project}', [PurchaseController::class,'purchaseInventory'])->name('purchase_inventory.all')->middleware('permission:purchase_inventory');
        Route::get('purchase-inventory-all-project', [PurchaseController::class,'purchaseInventoryAllProject'])->name('purchase_inventory.all.project')->middleware('permission:purchase_inventory');
        Route::get('purchase-inventory-print', [PurchaseController::class,'purchaseInventoryPrint'])->name('purchase_inventory_print')->middleware('permission:purchase_inventory');
        Route::get('purchase-inventory/datatable', [PurchaseController::class,'purchaseInventoryDatatable'])->name('purchase_inventory.datatable')->middleware('permission:purchase_inventory');
        Route::get('purchase-inventory/details/datatable', [PurchaseController::class,'purchaseInventoryDetailsDatatable'])->name('purchase_inventory.details.datatable')->middleware('permission:purchase_inventory');
        Route::get('purchase-inventory/details/{product}/{project}/{segment}', [PurchaseController::class,'purchaseInventoryDetails'])->name('purchase_inventory.details')->middleware('permission:purchase_inventory');
        Route::get('inventory-view-project-datatable', [PurchaseController::class,'inventoryViewDatatable'])->name('inventory_project.view.datatable')->middleware('permission:purchase_inventory');

        // purchase & requisition
        Route::get('purchase-requisition-all', [RequisitionController::class,'purchaseRequisition'])->name('purchase_requisition_report.all')->middleware('permission:purchase_and_requisition');
        //BOQ & Requisition
        Route::get('requisition-and-boq/report', [RequisitionController::class,'requisitionBoqReport'])->name('requisition.boq.report')->middleware('permission:requisition_and_boq');

        //utilize Purchase Product
        Route::get('utilize/all-project', [PurchaseController::class,'utilizeAllProject'])->name('utilize.all.project')->middleware('permission:utilize');
        Route::get('utilize/purchase-product/{project}', [PurchaseController::class,'utilizeIndex'])->name('purchase_product.utilize.all')->middleware('permission:utilize');
        Route::get('utilize/purchase-product/project/datatable',[PurchaseController::class,'utilizeDatatable'])->name('purchase_product.utilize.all.datatable')->middleware('permission:utilize');
        Route::get('utilize/add/{project}', [PurchaseController::class,'utilizeAdd'])->name('purchase_product.utilize.add')->middleware('permission:utilize');
        Route::post('utilize/add/{project}', [PurchaseController::class,'utilizeAddPost'])->middleware('permission:utilize');
        Route::get('utilize/all-project/datatable', [PurchaseController::class,'utilizeProjectDatatable'])->name('utilize_project.view.datatable')->middleware('permission:utilize');


        // Notification
        Route::get('notification', [NotificationController::class,'all'])->name('vendor.notification');
        Route::get('notification/mark-read', [NotificationController::class,'markRead'])->name('vendor.mark_read');
        Route::get('notification/read/{notification}', [NotificationController::class,'notificationRead'])->name('read_notification');


        // Common

//        Route::get('get-requisition-product', [CommonController::class,'getRequisitionQuantity'])->name('get_requisition_products');
//        Route::get('get-product-by-segment', [CommonController::class,'getProductFromRq'])->name('get_products_by_segment_from_rq');
//        Route::get('get-product-purchase-order', [CommonController::class,'getProductPurchaseOrder'])->name('get_product_purchase_order');
//        Route::get('get-purchase-info', [CommonController::class,'getPurchaseOrder'])->name('get_purchase_order');
//        Route::get('get-inventory-product', [CommonController::class,'getInventoryProduct'])->name('get_inventory_product');
//        Route::get('get-segment', [CommonController::class,'getSegment'])->name('get_segment');
//        Route::get('get-stakeholder', [CommonController::class,'getStakeholder'])->name('get_stakeholder');
//        Route::get('get-segment-data', [CommonController::class,'getSegmentData'])->name('get_segment_data');
//        Route::get('get-costing-segment', [CommonController::class,'getCostingSegment'])->name('get_costing_segment');
//        Route::get('get-product-purchase', [CommonController::class,'getProductPurchase'])->name('get_product_purchase');
//        Route::get('get-product-unit', [CommonController::class,'getProductUnit'])->name('get_unit');
//        Route::get('get-branch', [CommonController::class,'getBranch'])->name('get_branch');
//        Route::get('get-bank', [CommonController::class,'getBank'])->name('bank_account.get_bank');
//        Route::get('get-bank-account', [CommonController::class,'getBankAccount'])->name('get_bank_account');
//        Route::get('get-account-head-type', [CommonController::class,'getAccountHeadType'])->name('get_account_head_type');
//        Route::get('get-account-head-type-trx', 'CommonController@getAccountHeadTypeTrx')->name('get_account_head_type_trx');
//        Route::get('get-account-head-sub-type', [CommonController::class,'getAccountHeadSubType'])->name('get_account_head_sub_type');

        Route::get('get-cash-info', [CommonController::class,'getCashInfo'])->name('get_cash_info');
        Route::get('get-bank-amount-info', [CommonController::class,'getBankAmountInfo'])->name('get_bank_amount_info');
        Route::get('cash', [CommonController::class,'cash'])->name('cash')->middleware('permission:cash');
        Route::get('cash/add', [CommonController::class,'cashAdd'])->name('cash_add')->middleware('permission:cash');
        Route::post('cash/add', [CommonController::class,'cashStore'])->middleware('permission:cash');
        Route::post('cash', [CommonController::class,'cashPost'])->middleware('permission:cash');
        Route::get('cash-edit/{cash}', [CommonController::class,'cashEdit'])->name('cash.edit')->middleware('permission:cash');
        Route::post('cash-edit/{cash}', [CommonController::class,'cashEditPost'])->middleware('permission:cash');

    });

    Route::middleware(['custom:2-3'])->group(function () {
        //All Report
        Route::get('supplier-ledger', [ReportController::class,'supplierLedger'])->name('supplier.ledger');
        Route::get('contractor-ledger', [ReportController::class,'contractorLedger'])->name('contractor.ledger');
        Route::get('purchase-report', [ReportController::class,'purchaseReport'])->name('purchase.report');
        Route::get('stakeholder-report', [ReportController::class,'stakeholderReport'])->name('stakeholder.report');
        Route::get('stake-holder-report', [ReportController::class,'stakeholderReport'])->name('stake_holder.report');
        Route::get('project-report', [ReportController::class,'projectReport'])->name('project.report');
        Route::get('progress-report', [ReportController::class,'progressReport'])->name('progress.report');
        Route::get('report/transaction', [AccountsController::class,'reportTransaction'])->name('report.transaction');
        Route::get('project/report/transaction', [AccountsController::class,'projectReportTransaction'])->name('project.report.transaction');
        Route::get('project/report/receive/payment', [AccountsController::class,'projectReportReceivePayment'])->name('project.report.receive_and_payment');
        Route::get('report/receive/payment', [AccountsController::class,'reportReceivePayment'])->name('report.receive_and_payment');
        Route::get('report/bank/statement', [ReportController::class,'bankStatement'])->name('report.bank_statement');
        Route::get('report/cash/statement', [ReportController::class,'cashStatement'])->name('report.cash_statement');
        Route::get('report/all-receive-payment',[ReportController::class,'allReceivePayment'])->name('report.all_receive_payment');

//        Route::get('supplier-ledger', [ReportController::class,'supplierLedger'])->name('supplier.ledger')->middleware('permission:supplier_report');
//        Route::get('purchase-report', [ReportController::class,'purchaseReport'])->name('purchase.report')->middleware('permission:purchase_report');
//        Route::get('stakeholder-report', [ReportController::class,'stakeholderReport'])->name('stakeholder.report')->middleware('permission:stakeholder_report');
//        Route::get('project-report', [ReportController::class,'projectReport'])->name('project.report')->middleware('permission:project_report');
//        Route::get('progress-report', [ReportController::class,'progressReport'])->name('progress.report')->middleware('permission:progress_report');

    });

    // Common
    Route::get('get-requisition-product', [CommonController::class,'getRequisitionQuantity'])->name('get_requisition_products');
    Route::get('get-product-by-segment', [CommonController::class,'getProductFromRq'])->name('get_products_by_segment_from_rq');
    Route::get('get-product-purchase-order', [CommonController::class,'getProductPurchaseOrder'])->name('get_product_purchase_order');
    Route::get('get-purchase-info', [CommonController::class,'getPurchaseOrder'])->name('get_purchase_order');
    Route::get('get-inventory-product', [CommonController::class,'getInventoryProduct'])->name('get_inventory_product');
    Route::get('get-segment', [CommonController::class,'getSegment'])->name('get_segment');
    Route::get('get-requisition-id', [CommonController::class,'getRequisitionId'])->name('get_requisition_id');
    Route::get('get-stakeholder', [CommonController::class,'getStakeholder'])->name('get_stakeholder');
    Route::get('get-project-segment', [CommonController::class,'getProjectWiseSegment'])->name('get_project_wise_segment');
    Route::get('get-segment-data', [CommonController::class,'getSegmentData'])->name('get_segment_data');
    Route::get('get-costing-segment', [CommonController::class,'getCostingSegment'])->name('get_costing_segment');
    Route::get('get-product-purchase', [CommonController::class,'getProductPurchase'])->name('get_product_purchase');
    Route::get('get-product-unit', [CommonController::class,'getProductUnit'])->name('get_unit');
    Route::get('get-branch', [CommonController::class,'getBranch'])->name('get_branch');
    Route::get('get-bank', [CommonController::class,'getBank'])->name('bank_account.get_bank');
    Route::get('get-bank-account', [CommonController::class,'getBankAccount'])->name('get_bank_account');
    Route::get('get-account-head-type', [CommonController::class,'getAccountHeadType'])->name('get_account_head_type');
    Route::get('get-account-head-type-trx', 'CommonController@getAccountHeadTypeTrx')->name('get_account_head_type_trx');
    Route::get('get-account-head-sub-type', [CommonController::class,'getAccountHeadSubType'])->name('get_account_head_sub_type');

    Route::get('/cache-clear', function () {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('config:cache');
        Artisan::call('view:clear');
        return "Cleared!";
    });
});

//Route::get('/stack-holder-login/{user}', [HomeController::class, 'stackHolderLogin'])->name('admin.stack_holder_login');

