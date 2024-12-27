<?php

use App\Http\Controllers\AdminRouteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\ContentCreatorRouteController;
use App\Http\Controllers\EkycController;
use App\Http\Controllers\emailController;
use App\Http\Controllers\OrganizationRouteController;
use App\Http\Controllers\StaffRouteController;
use App\Http\Controllers\JobScraperController;
use App\Http\Controllers\GPTChatBot;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MicrolearningController;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\TransactionController; // Ensure you import the controller at the top


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/', function () {

    return view('welcome');
});

Route::get('/jobs', [JobScraperController::class, 'index']);
Route::get('/jobstreet', [JobScraperController::class, 'indexJobStreet']);
Route::get('/fetch-jobs', [JobScraperController::class, 'fetchJobs']);
Route::get('/get-suggested-location', [JobScraperController::class, 'searchLocationsSuggest']);

Route::get('/login', [AuthController::class, 'viewLogin'])->name('viewLogin');
Route::get('/verify-code', [AuthController::class, 'viewVerify'])->name('viewVerify');
Route::get('/verify-user-organization', [AuthController::class, 'viewVerifyUserOrganization'])->name('viewVerifyUserOrganization');
Route::get('/verify-user-content-creator', [AuthController::class, 'viewVerifyUserContentCreator'])->name('viewVerifyUserContentCreator');
Route::get('/resend-code', [AuthController::class, 'resendVerify'])->name('resendVerify');
Route::get('/organization-register', [AuthController::class, 'viewOrganizationRegister'])->name('viewOrganizationRegister');
Route::get('/organization-register-user/{data}', [AuthController::class, 'viewOrganizationRegisterUser'])->name('viewOrganizationRegisterUser');
Route::get('/content-creator-register', [AuthController::class, 'viewContentCreatorRegister'])->name('viewContentCreatorRegister');
Route::get('/content-creator-register-user/{data}', [AuthController::class, 'viewContentCreatorRegisterUser'])->name('viewContentCreatorRegisterUser');
Route::get('/reset-password', [AuthController::class, 'viewResetPassword'])->name('viewResetPassword');


Route::get('/request-delete-acc', [AuthController::class, 'requestDelAcc'])->name('requestDelAcc');
Route::get('/policy', [AuthController::class, 'policy'])->name('policy');


Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/organization-register', [AuthController::class, 'createOrganizationRegister'])->name('createOrganizationRegister');
Route::post('/content-creator-register', [AuthController::class, 'createContentCreatorRegister'])->name('createContentCreatorRegister');
Route::post('/verify-user-organization', [AuthController::class, 'verifyUserOrganization'])->name('verifyUserOrganization');
Route::post('/verify-user-content-creator', [AuthController::class, 'verifyUserContentCretor'])->name('verifyUserContentCretor');
Route::post('/verify-code', [AuthController::class, 'verifyCode'])->name('verifyCode');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('resetPassword');
Route::get('/resend-email-reset-password', [AuthController::class, 'resendResetPassword'])->name('resendResetPassword');

Route::get('/check-mobile', [EkycController::class, 'CheckMobile'])->name('CheckMobile');


Route::get('/card-verification/{data}', [EkycController::class, 'CardVerification'])->name('CardVerification');
Route::get('/face-verification', [EkycController::class, 'FaceVerification'])->name('FaceVerification');
Route::get('/verification-process', [EkycController::class, 'VerificationSuccess'])->name('VerificationSuccess');
Route::get('/generate-qrcode', [EkycController::class, 'GenerateQrCode'])->name('GenerateQrCode');

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::prefix('admin')->middleware(['auth', 'role:1'])->group(function () {

    Route::get('/dashboard', [AdminRouteController::class, 'showDashboard'])->name('showDashboardAdmin');
    Route::get('/user', [AdminRouteController::class, 'showUser'])->name('showUserAdmin');
    Route::get('/user-mobile', [AdminRouteController::class, 'showUserMobile'])->name('showUserMobile');
    Route::get('/add-user', [AdminRouteController::class, 'showAddUser'])->name('showAddUser');
    Route::get('/view-content', [AdminRouteController::class, 'showContentAdmin'])->name('showContentAdmin');
    Route::get('/view-xbug-stand', [AdminRouteController::class, 'showxBugStandAdmin'])->name('showxBugStandAdmin');
    Route::get('/content-user', [AdminRouteController::class, 'showContentUserClickedViewed'])->name('showContentUserClickedViewed');
    Route::get('/content-user-enrolled', [AdminRouteController::class, 'showContentUserEnrolled'])->name('showContentUserEnrolled');
    Route::get('/content-detail/{content_id}/{interaction_type}', [AdminRouteController::class, 'getContentDetail'])->name('content.detail');
    Route::get('/transaction/{id}', [AdminRouteController::class, 'showReceipt'])->name('showReceipt');


    Route::get('/transaction-history-promote-content', [AdminRouteController::class, 'showTransactionHistoryPromoteContent'])->name('showTransactionHistoryPromoteContent');
    Route::get('/transaction-history-xbug-card', [AdminRouteController::class, 'showTransactionHistoryXbugCard'])->name('showTransactionHistoryXbugCard');



    Route::get('/content-cards/{contentId}', [AdminRouteController::class, 'getContentCards'])->name('admin.content-cards');
    Route::post('/save-content-cards', [AdminRouteController::class, 'saveContentCards'])->name('admin.save-content-cards');


    Route::get('/profile',  [AdminRouteController::class, 'showProfile'])->name('showProfileAdmin');
    Route::get('/email-logs',  [AdminRouteController::class, 'showEmailLogs'])->name('showEmailLogs');
    Route::get('/gpt-usage', [GPTChatBot::class, 'getUsage'])->name('getUsage');
    Route::get('/gpt-model', [GPTChatBot::class, 'showModelGpt'])->name('showModelGpt');
    Route::post('/update-gpt-model/{id}', [GPTChatBot::class, 'updateGptModel'])->name('updateGptModel');
    Route::get('/gpt-log', [GPTChatBot::class, 'showGptLog'])->name('showGptLog');
    
    Route::get('/chatbot', [GPTChatBot::class, 'showChatBotAdmin'])->name('showChatBotAdmin');
    Route::get('/gpt-model', [GPTChatBot::class, 'showGptModel'])->name('showGptModel');
    Route::get('/email-notification-logs', [emailController::class, 'showNotificationLogs'])->name('showNotificationLogs');
    Route::post('/chatbot/send', [GPTChatBot::class, 'sendMessageAdmin'])->name('sendMessageAdmin');
    
    Route::get('/email', [emailController::class, 'showEmail'])->name('showEmail');
    Route::post('/send-email', [emailController::class, 'sendEmail'])->name('sendEmail');
    Route::post('/send-email-to-all', [emailController::class, 'sendEmailToAll'])->name('sendEmailToAll');
    Route::get('/package', [AdminRouteController::class, 'showPackage'])->name('showPackage');
    Route::get('/email-status', [AdminRouteController::class, 'emailStatus'])->name('emailStatus');
    Route::post('/email-status/{id}', [AdminRouteController::class, 'emailStatusUpdate'])->name('emailStatusUpdate');
    
    
    Route::get('/card-logs', [EkycController::class, 'showCardLogs'])->name('showCardLogs');
    Route::get('/face-logs', [EkycController::class, 'showFaceLogs'])->name('showFaceLogs');
    
    Route::post('/update-gpt-model-status/{id}', [GPTChatBot::class, 'updateGptModelStatus'])->name('updateGptModelStatus');
    Route::post('/approve-content/{id}', [ContentController::class, 'approveContent'])->name('approveContent');
    Route::post('/reject-content/{id}', [ContentController::class, 'rejectContent'])->name('rejectContent');
    Route::post('/update-user/{id}', [UserManagementController::class, 'updateUser'])->name('updateUser');
    Route::post('/update-user-mobile/{id}', [UserManagementController::class, 'updateUserMobile'])->name('updateUserMobile');
    Route::post('/update-role/{id}', [UserManagementController::class, 'updateRole'])->name('updateRole');
    Route::delete('/user-delete/{id}', [UserManagementController::class, 'userDeleteAdmin'])->name('userDeleteAdmin');
    Route::post('/update-ekyc-status/{id}', [UserManagementController::class, 'updateEkycStatus'])->name('updateEkycStatus');
    Route::post('/update-email-status/{id}', [UserManagementController::class, 'updateEmailStatus'])->name('updateEmailStatus');
    Route::post('/update-gpt-account/{id}', [UserManagementController::class, 'updateGptAccount'])->name('updateGptAccount');
    Route::post('/update-gpt-status/{id}', [UserManagementController::class, 'updateGptStatus'])->name('updateGptStatus');
    Route::post('/update-email-email-mobile/{id}', [UserManagementController::class, 'updateEmailStatusMobile'])->name('updateEmailStatusMobile');
    Route::post('/update-email-status-mobile/{id}', [UserManagementController::class, 'updateAccountStatusMobile'])->name('updateAccountStatusMobile');
    Route::post('/update-account-status/{id}', [UserManagementController::class, 'updateAccountStatus'])->name('updateAccountStatus');
    Route::post('/profile/update-personal-detail', [UserProfileController::class, 'updateProfilePersonalDetailAdmin'])->name('updateProfilePersonalDetailAdmin');
    Route::post('/profile/update-password', [UserProfileController::class, 'updatePasswordAdmin'])->name('updatePasswordAdmin');

    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('admin.logout');
});

//Route::prefix('microlearning')->group(function () {
//    Route::get('/', [MicrolearningController::class, 'index'])->name('microlearning.index'); // List lessons
//    Route::get('/lesson/{id}', [MicrolearningController::class, 'lesson'])->name('microlearning.lesson'); // Show single lesson
//    Route::get('/quiz', [MicrolearningController::class, 'quiz'])->name('microlearning.quiz'); // Quiz page
//});



Route::post('directpayIndex', [TransactionController::class, 'directpayIndex'])->name('directpayIndex');
Route::get('testcallback', [TransactionController::class, 'testcallback']);
Route::post('directpayReceipt', [TransactionController::class, 'directpayReceipt'])->name('directpayReceipt');
Route::get('payment_template', [TransactionController::class, 'index'])->name('payment_template');



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


Route::prefix('organization')->middleware(['auth', 'role:2'])->group(function () {
    Route::get('/dashboard', [OrganizationRouteController::class, 'showDashboard'])->name('showDashboardOrganization');
    Route::get('/profile', [OrganizationRouteController::class, 'showProfile'])->name('showProfileOrganization');
    Route::get('/MicroLearning', [OrganizationRouteController::class, 'showMicroLearningForm'])->name('showMicroLearningForm');
    Route::get('/chatbot', [GPTChatBot::class, 'showChatBot'])->name('showChatBot');
    Route::get('/notifications', [OrganizationRouteController::class, 'showNotification'])->name('showNotification');
    Route::get('/api/getLabels', [ContentController::class, 'getLabels'])->name('getLabels');
    Route::post('/chatbot/send', [GPTChatBot::class, 'sendMessage'])->name('sendMessage');
    Route::get('/content-user', [OrganizationRouteController::class, 'showContentUserClickedViewedOrganization'])->name('showContentUserClickedViewedOrganization');
    Route::get('/content-user-enrolled', [OrganizationRouteController::class, 'showContentUserEnrolledOrganization'])->name('showContentUserEnrolledOrganization');
    Route::get('/content-detail/{content_id}/{interaction_type}', [OrganizationRouteController::class, 'getContentDetailOrganization'])->name('getContentDetailOrganization');

    Route::get('/transaction-history-promote-content', [OrganizationRouteController::class, 'showTransactionHistoryPromoteContentOrg'])->name('showTransactionHistoryPromoteContentOrg');
    Route::get('/transaction-history-xbug-card', [OrganizationRouteController::class, 'showTransactionHistoryXbugCardOrg'])->name('showTransactionHistoryXbugCardOrg');

    // Route::middleware(['ekycCheck'])->group(function () {
    Route::get('/content-management', [OrganizationRouteController::class, 'showContent'])->name('showContent');
    Route::get('/apply-content', [OrganizationRouteController::class, 'showAddContent'])->name('showAddContent');
    Route::post('/MicroLearning', [ContentController::class, 'uploadMicroLearning'])->name('uploadMicroLearning');
    Route::post('/apply-content', [ContentController::class, 'addContent'])->name('addContentOrganization');
    Route::post('/apply-card/{content_id}', [ContentController::class, 'addCard'])->name('addCardOrganization');

    Route::post('/profile/update-personal-detail', [UserProfileController::class, 'updateProfilePersonalDetailOrganization'])->name('updateProfilePersonalDetailOrganization');
    Route::post('/profile/update-organization-Detail', [UserProfileController::class, 'updateProfileOrganizationDetail'])->name('updateProfileOrganizationDetail');
    Route::post('/profile/update-password', [UserProfileController::class, 'updatePasswordOrganization'])->name('updatePasswordOrganization');
    // });

    // Route::get('/promote-content', function () use ($states_list) {
    //     return view('organization.contentManagement.promoteContent', compact('states_list'));
    // });

    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('organization.logout');
});


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


Route::prefix('content-creator')->middleware(['auth', 'role:3'])->group(function () {
    Route::get('/dashboard', [ContentCreatorRouteController::class, 'showDashboard'])->name('showDashboardContentCreator');
    Route::get('/profile', [ContentCreatorRouteController::class, 'showProfile'])->name('showProfileContentCreator');
    Route::get('/apply-content', [ContentCreatorRouteController::class, 'showAddContentForm'])->name('showAddContentForm');
    Route::get('/MicroLearning', [ContentCreatorRouteController::class, 'showMicroLearning'])->name('showMicrolearningContentCreator');
    Route::get('/api/getLabels', [ContentController::class, 'getLabels'])->name('getLabelsContentCreator');

    Route::post('/profile/update-personal-detail', [UserProfileController::class, 'updateProfilePersonalDetailContentCreator'])->name('updateProfilePersonalDetailContentCreator');
    Route::post('/profile/update-password', [UserProfileController::class, 'updatePasswordContentCreator'])->name('updatePasswordContentCreator');
    Route::post('/apply-content', [ContentCreatorRouteController::class, 'addContent'])->name('addContentContentCreator');
    Route::post('/MicroLearning', [ContentController::class, 'uploadMicroLearning'])->name('uploadMicroLearningContentCreator');

    // Route::middleware(['ekycCheck'])->group(function () {

    // });

    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('content-creator.logout');
});


Route::prefix('promote-content')->middleware(['auth', 'role:1|3|4'])->group(function () {
    Route::post('/payment', [ContentController::class, 'promoteContentPayment'])->name('promote-content.payment');
    Route::get('/receipt/{t_id}', [ContentController::class, 'promoteContentReceipt'])->name('promote-content.receipt');

    
});

Route::prefix('xbug-stand')->middleware(['auth', 'role:1|3|4'])->group(function () {
    Route::get('/receipt/{t_id}', [ContentController::class, 'xbugStandReceipt'])->name('xbug-stand.receipt');

});

Route::prefix('gpt-payment')->middleware(['auth', 'role:1|3|4'])->group(function () {
    Route::post('/apply-chatbot', [GPTChatBot::class, 'applyChatBot'])->name('applyChatBot');
    Route::get('/receipt/{id}', [GPTChatBot::class, 'xbugGptReceipt'])->name('xbugGptReceipt');

});


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/microlearning/upload', [MicrolearningController::class, 'upload']);
Route::get('/microlearning', [MicrolearningController::class, 'index']);
Route::get('/content/{id}', [MicrolearningController::class, 'show']);
// Route::get('/view-microlearning', [MicrolearningController::class, 'showMicrolearning'])->name('showMicrolearning');
// Route::get('/view-microlearning/{id}', [MicrolearningController::class, 'showMicrolearningDetail'])->name('showMicrolearningDetail');

Route::get('/view-content', [MicrolearningController::class, 'showContentHomepage'])->name('showContentHomepage');
//Route::get('/view-content/{id}', [MicrolearningController::class, 'showContentDetail'])->name('showContentDetail');
Route::get('/view-content/{slug}', [MicrolearningController::class, 'showContentDetail'])->name('showContentDetail');
// Route::get('/view-content/{slug}/{id}', [MicrolearningController::class, 'showContentDetail'])->name('showContentDetail');
Route::get('/view-content/{slug}/{name}', [MicrolearningController::class, 'showMicrolearningDetail'])->name('showMicrolearningDetail');




Route::get('/deeplink/{id}', [ContentController::class, 'deeplink'])->name('deeplink');
//Route::get('/deeplink', [ContentController::class, 'deeplink'])->name('deeplink2');
Route::get('/guest/{card_id}', [ContentController::class, 'guest'])->name('guest');
Route::post('/guest/{card_id}/register', [ContentController::class, 'registerGuestContent'])->name('registerGuestContent');
