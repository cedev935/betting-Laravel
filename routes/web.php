<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

Route::get('/themeMode/{themeType?}', function ($themeType = 'true') {
    session()->put('dark-mode', $themeType);
    return $themeType;
})->name('themeMode');

Route::get('migrate', function () {
    return Illuminate\Support\Facades\Artisan::call('migrate');
});
Route::get('gateway-update', function () {
    return Illuminate\Support\Facades\Artisan::call('gateway:update');
});


Route::get('/clear', function () {
    $output = new \Symfony\Component\Console\Output\BufferedOutput();
    Artisan::call('optimize:clear', array(), $output);
    return $output->fetch();
})->name('/clear');

//Result
Route::get('/bet/result', 'FrontendController@betResult')->name('betResult');

Route::get('/user', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/loginModal', 'Auth\LoginController@loginModal')->name('loginModal');

Route::post('/khalti/payment/verify/{trx}', 'khaltiPaymentController@verifyPayment')->name('khalti.verifyPayment');
Route::post('/khalti/payment/store', 'khaltiPaymentController@storePayment')->name('khalti.storePayment');

Route::get('queue-work', function () {
    return Illuminate\Support\Facades\Artisan::call('queue:work', ['--stop-when-empty' => true]);
})->name('queue.work');

Route::get('cron', function () {
    return Illuminate\Support\Facades\Artisan::call('cron:run');
})->name('cron');

Route::get('rate-update', function () {
    return Illuminate\Support\Facades\Artisan::call('schedule:run');
})->name('rate-update');


Auth::routes(['verify' => true]);

Route::group(['middleware' => ['guest']], function () {
    Route::get('register/{sponsor?}', 'Auth\RegisterController@sponsor')->name('register.sponsor');
});

Route::group(['middleware' => ['auth'], 'prefix' => 'user', 'as' => 'user.'], function () {
    Route::get('/check', 'User\VerificationController@check')->name('check');
    Route::get('/resend_code', 'User\VerificationController@resendCode')->name('resendCode');
    Route::post('/mail-verify', 'User\VerificationController@mailVerify')->name('mailVerify');
    Route::post('/sms-verify', 'User\VerificationController@smsVerify')->name('smsVerify');
    Route::post('twoFA-Verify', 'User\VerificationController@twoFAverify')->name('twoFA-Verify');
    Route::middleware('userCheck')->group(function () {
        Route::middleware('kyc')->group(function () {

            //Bet History
            Route::get('/bet-history', 'User\BetHistoryController@betList')->name('betHistory');


            Route::get('/dashboard', 'User\HomeController@index')->name('home');
            Route::post('/betSlip', 'User\HomeController@betSlip')->name('betSlip');

            Route::get('add-fund', 'User\HomeController@addFund')->name('addFund');
            Route::post('add-fund', 'PaymentController@addFundRequest')->name('addFund.request');
            Route::get('addFundConfirm', 'PaymentController@depositConfirm')->name('addFund.confirm');
            Route::post('addFundConfirm', 'PaymentController@fromSubmit')->name('addFund.fromSubmit');


            //transaction
            Route::get('/transaction', 'User\HomeController@transaction')->name('transaction');
            Route::get('/transaction-search', 'User\HomeController@transactionSearch')->name('transaction.search');
            Route::get('fund-history', 'User\HomeController@fundHistory')->name('fund-history');
            Route::get('fund-history-search', 'User\HomeController@fundHistorySearch')->name('fund-history.search');


            // TWO-FACTOR SECURITY
            Route::get('/twostep-security', 'User\HomeController@twoStepSecurity')->name('twostep.security');
            Route::post('twoStep-enable', 'User\HomeController@twoStepEnable')->name('twoStepEnable');
            Route::post('twoStep-disable', 'User\HomeController@twoStepDisable')->name('twoStepDisable');


            Route::get('push-notification-show', 'SiteNotificationController@show')->name('push.notification.show');
            Route::get('push.notification.readAll', 'SiteNotificationController@readAll')->name('push.notification.readAll');
            Route::get('push-notification-readAt/{id}', 'SiteNotificationController@readAt')->name('push.notification.readAt');


            Route::get('/withdraw', 'User\HomeController@payoutMoney')->name('payout.money');
            Route::post('/withdraw', 'User\HomeController@payoutMoneyRequest')->name('payout.moneyRequest');
            Route::get('/withdraw/preview', 'User\HomeController@payoutPreview')->name('payout.preview');
            Route::post('/withdraw/preview', 'User\HomeController@payoutRequestSubmit')->name('payout.submit');
            Route::post('/withdraw/paystack/{trx_id}', 'User\HomeController@paystackPayout')->name('payout.submit.paystack');
            Route::post('/withdraw/flutterwave/{trx_id}', 'User\HomeController@flutterwavePayout')->name('payout.submit.flutterwave');
            Route::post('withdraw-bank-list', 'User\HomeController@getBankList')->name('payout.getBankList');
            Route::post('withdraw-bank-from', 'User\HomeController@getBankForm')->name('payout.getBankFrom');

            Route::get('withdraw/history', 'User\HomeController@payoutHistory')->name('payout.history');
            Route::get('withdraw/history/search', 'User\HomeController@payoutHistorySearch')->name('payout.history.search');

            Route::get('/invite-friends', 'User\HomeController@referral')->name('referral');
            Route::get('/referral-bonus', 'User\HomeController@referralBonus')->name('referral.bonus');
            Route::get('/referral-bonus/search', 'User\HomeController@referralBonusSearch')->name('referral.bonus.search');


        });

        Route::get('/profile', 'User\HomeController@profile')->name('profile');
        Route::post('/updateProfile', 'User\HomeController@updateProfile')->name('updateProfile');
        Route::put('/updateInformation', 'User\HomeController@updateInformation')->name('updateInformation');
        Route::post('/updatePassword', 'User\HomeController@updatePassword')->name('updatePassword');

        Route::post('/verificationSubmit', 'User\HomeController@verificationSubmit')->name('verificationSubmit');
        Route::post('/addressVerification', 'User\HomeController@addressVerification')->name('addressVerification');


        Route::group(['prefix' => 'ticket', 'as' => 'ticket.'], function () {
            Route::get('/', 'User\SupportController@index')->name('list');
            Route::get('/create', 'User\SupportController@create')->name('create');
            Route::post('/create', 'User\SupportController@store')->name('store');
            Route::get('/view/{ticket}', 'User\SupportController@ticketView')->name('view');
            Route::put('/reply/{ticket}', 'User\SupportController@reply')->name('reply');
            Route::get('/download/{ticket}', 'User\SupportController@download')->name('download');
        });


    });
});


Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/', 'Admin\LoginController@showLoginForm')->name('login');
    Route::post('/', 'Admin\LoginController@login')->name('login');
    Route::post('/logout', 'Admin\LoginController@logout')->name('logout');


    Route::get('/password/reset', 'Admin\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('/password/email', 'Admin\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('/password/reset/{token}', 'Admin\Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('/password/reset', 'Admin\Auth\ResetPasswordController@reset')->name('password.update');


    Route::get('/403', 'Admin\DashboardController@forbidden')->name('403');

    Route::group(['middleware' => ['auth:admin', 'permission']], function () {
        Route::get('/dashboard', 'Admin\DashboardController@dashboard')->name('dashboard');

        Route::get('/staff', 'Admin\ManageRolePermissionController@staff')->name('staff');
        Route::post('/staff', 'Admin\ManageRolePermissionController@storeStaff')->name('storeStaff');
        Route::put('/staff/{id}', 'Admin\ManageRolePermissionController@updateStaff')->name('updateStaff');

        Route::get('/referral-commission', 'Admin\DashboardController@referralCommission')->name('referral-commission');
        Route::post('/referral-commission', 'Admin\DashboardController@referralCommissionStore')->name('referral-commission.store');
        Route::post('/referral-commission/action', 'Admin\DashboardController@referralCommissionAction')->name('referral-commission.action');


        //Manage Category
        Route::get('category/list', 'Admin\CategoryController@listCategory')->name('listCategory');
        Route::post('category/store', 'Admin\CategoryController@storeCategory')->name('storeCategory');
        Route::post('category/update/{id}', 'Admin\CategoryController@updateCategory')->name('updateCategory');
        Route::delete('category/delete/{id}', 'Admin\CategoryController@deleteCategory')->name('deleteCategory');

        Route::post('category-active', 'Admin\CategoryController@activeMultiple')->name('category-active');
        Route::post('category-deactive', 'Admin\CategoryController@deActiveMultiple')->name('category-deactive');

        //Manage Tournament
        Route::get('tournament/list', 'Admin\TournamentController@listTournament')->name('listTournament');
        Route::post('tournament/store', 'Admin\TournamentController@storeTournament')->name('storeTournament');
        Route::post('tournament/update/{id}', 'Admin\TournamentController@updateTournament')->name('updateTournament');
        Route::delete('tournament/delete/{id}', 'Admin\TournamentController@deleteTournament')->name('deleteTournament');

        Route::post('tournament-active', 'Admin\TournamentController@activeMultiple')->name('tournament-active');
        Route::post('tournament-deactive', 'Admin\TournamentController@deActiveMultiple')->name('tournament-deactive');

        //Manage Team
        Route::get('team/list', 'Admin\TeamController@listTeam')->name('listTeam');
        Route::post('team/store', 'Admin\TeamController@storeTeam')->name('storeTeam');
        Route::post('team/update/{id}', 'Admin\TeamController@updateTeam')->name('updateTeam');
        Route::delete('team/delete/{id}', 'Admin\TeamController@deleteTeam')->name('deleteTeam');

        Route::post('team-active', 'Admin\TeamController@activeMultiple')->name('team-active');
        Route::post('team-deactive', 'Admin\TeamController@deActiveMultiple')->name('team-deactive');


        //Manage Match
        Route::get('match/list', 'Admin\MatchController@listMatch')->name('listMatch');
        Route::get('match/search', 'Admin\MatchController@searchMatch')->name('searchMatch');
        Route::post('match/store', 'Admin\MatchController@storeMatch')->name('storeMatch');
        Route::post('match/update/{id}', 'Admin\MatchController@updateMatch')->name('updateMatch');
        Route::delete('match/delete/{id}', 'Admin\MatchController@deleteMatch')->name('deleteMatch');
        Route::post('match/locker', 'Admin\MatchController@matchLocker')->name('match.locker');

        //Manage Match Question
        Route::get('match/question/{id}', 'Admin\MatchController@infoMatch')->name('infoMatch');
        Route::get('match/question/add/{match_id}', 'Admin\MatchController@addQuestion')->name('addQuestion');
        Route::post('match/question/save', 'Admin\MatchController@storeQuestion')->name('storeQuestion');
        Route::post('match/question/update', 'Admin\MatchController@updateQuestion')->name('updateQuestion');
        Route::delete('match/question/delete/{id}', 'Admin\MatchController@deleteQuestion')->name('deleteQuestion');
        Route::post('match/question/active', 'Admin\MatchController@activeQsMultiple')->name('question-active');
        Route::post('match/question/deactive', 'Admin\MatchController@deActiveQsMultiple')->name('question-deactive');
        Route::post('match/question/close', 'Admin\MatchController@closeQsMultiple')->name('question-close');

        Route::post('ajax-match/list', 'Admin\MatchController@ajaxListMatch')->name('ajax.listMatch');
        Route::post('match-active', 'Admin\MatchController@activeMultiple')->name('match-active');
        Route::post('match-deactive', 'Admin\MatchController@deActiveMultiple')->name('match-deactive');

        //Match Option
        Route::get('optionList/{question_id?}', 'Admin\MatchOptionController@optionList')->name('optionList');
        Route::post('optionAdd', 'Admin\MatchOptionController@optionAdd')->name('optionAdd');
        Route::post('optionUpdate', 'Admin\MatchOptionController@optionUpdate')->name('optionUpdate');
        Route::post('optionDelete', 'Admin\MatchOptionController@optionDelete')->name('optionDelete');
        Route::post('question/locker', 'Admin\MatchOptionController@questionLocker')->name('question.locker');


        //Manage Bet
        Route::get('/bet-history/{user_id?}', 'Admin\ManageBetController@betList')->name('historyBet');
        Route::get('/bet/history/search', 'Admin\ManageBetController@betSearch')->name('searchBet');
        Route::post('/bet/refund', 'Admin\ManageBetController@betRefund')->name('refundBet');

        //Manage Result
        Route::get('/result/history/pending', 'Admin\ManageResultController@resultList')->name('resultList.pending');
        Route::get('/result/history/complete', 'Admin\ManageResultController@resultList')->name('resultList.complete');
        Route::get('/result/history/search', 'Admin\ManageResultController@resultSearch')->name('searchResult');
        Route::post('/result/winner', 'Admin\ManageResultController@makeWinner')->name('makeWinner');
        Route::get('/result/winner/{question_id}', 'Admin\ManageResultController@resultWinner')->name('resultWinner');
        Route::get('/bet/user/{question_id}', 'Admin\ManageResultController@betUser')->name('betUser');
        Route::post('/bet/refundQuestion/{id}', 'Admin\ManageResultController@refundQuestion')->name('refundQuestion');

        Route::get('/profile', 'Admin\DashboardController@profile')->name('profile');
        Route::put('/profile', 'Admin\DashboardController@profileUpdate')->name('profileUpdate');
        Route::get('/password', 'Admin\DashboardController@password')->name('password');
        Route::put('/password', 'Admin\DashboardController@passwordUpdate')->name('passwordUpdate');


        Route::get('/identity-form', 'Admin\IdentyVerifyFromController@index')->name('identify-form');
        Route::post('/identity-form', 'Admin\IdentyVerifyFromController@store')->name('identify-form.store');
        Route::post('/identity-form/action', 'Admin\IdentyVerifyFromController@action')->name('identify-form.action');


        /* ====== Transaction Log =====*/
        Route::get('/transaction', 'Admin\LogController@transaction')->name('transaction');
        Route::get('/transaction-search', 'Admin\LogController@transactionSearch')->name('transaction.search');

        Route::get('/commissions', 'Admin\LogController@commissions')->name('commissions');
        Route::get('/commissions-search', 'Admin\LogController@commissionsSearch')->name('commissions.search');


        /*====Manage Users ====*/
        Route::get('/users', 'Admin\UsersController@index')->name('users');
        Route::get('/users/search', 'Admin\UsersController@search')->name('users.search');
        Route::post('/users-active', 'Admin\UsersController@activeMultiple')->name('user-multiple-active');
        Route::post('/users-inactive', 'Admin\UsersController@inactiveMultiple')->name('user-multiple-inactive');
        Route::get('/user/edit/{id}', 'Admin\UsersController@userEdit')->name('user-edit');
        Route::post('/user/login', 'Admin\UsersController@userLogin')->name('userLogin');
        Route::post('/user/update/{id}', 'Admin\UsersController@userUpdate')->name('user-update');
        Route::post('/user/password/{id}', 'Admin\UsersController@passwordUpdate')->name('userPasswordUpdate');
        Route::post('/user/balance-update/{id}', 'Admin\UsersController@userBalanceUpdate')->name('user-balance-update');

        Route::get('/user/send-email/{id}', 'Admin\UsersController@sendEmail')->name('send-email');
        Route::post('/user/send-email/{id}', 'Admin\UsersController@sendMailUser')->name('user.email-send');
        Route::get('/user/transaction/{id}', 'Admin\UsersController@transaction')->name('user.transaction');
        Route::get('/user/fundLog/{id}', 'Admin\UsersController@funds')->name('user.fundLog');
        Route::get('/user/payoutLog/{id}', 'Admin\UsersController@payoutLog')->name('user.withdrawal');
        Route::get('/user/referralMember/{id}', 'Admin\UsersController@referralMember')->name('user.referralMember');
        Route::get('/user/commissionLog/{id}', 'Admin\UsersController@commissionLog')->name('user.commissionLog');

        Route::get('users/kyc/pending', 'Admin\UsersController@kycPendingList')->name('kyc.users.pending');
        Route::get('users/kyc', 'Admin\UsersController@kycList')->name('kyc.users');
        Route::put('users/kycAction/{id}', 'Admin\UsersController@kycAction')->name('users.Kyc.action');
        Route::get('user/{user}/kyc', 'Admin\UsersController@userKycHistory')->name('user.userKycHistory');

        Route::get('/email-send', 'Admin\UsersController@emailToUsers')->name('email-send');
        Route::post('/email-send', 'Admin\UsersController@sendEmailToUsers')->name('email-send.store');

        //Plugin
        Route::get('/plugin-config', 'Admin\BasicController@pluginConfig')->name('plugin.config');
        Route::match(['get', 'post'], 'tawk-config', 'Admin\BasicController@tawkConfig')->name('tawk.control');
        Route::match(['get', 'post'], 'fb-messenger-config', 'Admin\BasicController@fbMessengerConfig')->name('fb.messenger.control');
        Route::match(['get', 'post'], 'google-recaptcha', 'Admin\BasicController@googleRecaptchaConfig')->name('google.recaptcha.control');
        Route::match(['get', 'post'], 'google-analytics', 'Admin\BasicController@googleAnalyticsConfig')->name('google.analytics.control');


        /*=====Payment Log=====*/
        Route::get('payment-methods', 'Admin\PaymentMethodController@index')->name('payment.methods');
        Route::post('payment-methods/deactivate', 'Admin\PaymentMethodController@deactivate')->name('payment.methods.deactivate');
        Route::get('payment-methods/deactivate', 'Admin\PaymentMethodController@deactivate')->name('payment.methods.deactivate');
        Route::post('sort-payment-methods', 'Admin\PaymentMethodController@sortPaymentMethods')->name('sort.payment.methods');
        Route::get('payment-methods/edit/{id}', 'Admin\PaymentMethodController@edit')->name('edit.payment.methods');
        Route::put('payment-methods/update/{id}', 'Admin\PaymentMethodController@update')->name('update.payment.methods');


        // Manual Methods
        Route::get('payment-methods/manual', 'Admin\ManualGatewayController@index')->name('deposit.manual.index');
        Route::get('payment-methods/manual/new', 'Admin\ManualGatewayController@create')->name('deposit.manual.create');
        Route::post('payment-methods/manual/new', 'Admin\ManualGatewayController@store')->name('deposit.manual.store');
        Route::get('payment-methods/manual/edit/{id}', 'Admin\ManualGatewayController@edit')->name('deposit.manual.edit');
        Route::put('payment-methods/manual/update/{id}', 'Admin\ManualGatewayController@update')->name('deposit.manual.update');


        Route::get('payment/pending', 'Admin\PaymentLogController@pending')->name('payment.pending');
        Route::put('payment/action/{id}', 'Admin\PaymentLogController@action')->name('payment.action');
        Route::get('payment/log', 'Admin\PaymentLogController@index')->name('payment.log');
        Route::get('payment/search', 'Admin\PaymentLogController@search')->name('payment.search');


        /*==========Payout Settings============*/
        Route::get('/payout-method', 'Admin\PayoutGatewayController@index')->name('payout-method');
        Route::get('/payout-method/create', 'Admin\PayoutGatewayController@create')->name('payout-method.create');
        Route::post('/payout-method/create', 'Admin\PayoutGatewayController@store')->name('payout-method.store');
        Route::get('/payout-method/{id}', 'Admin\PayoutGatewayController@edit')->name('payout-method.edit');
        Route::put('/payout-method/{id}', 'Admin\PayoutGatewayController@update')->name('payout-method.update');

        Route::get('/payout-log', 'Admin\PayoutRecordController@index')->name('payout-log');
        Route::get('/payout-log/search', 'Admin\PayoutRecordController@search')->name('payout-log.search');
        Route::get('/payout-request', 'Admin\PayoutRecordController@request')->name('payout-request');
        Route::get('/withdraw-view/{id}', 'Admin\PayoutRecordController@view')->name('payout-view');
        Route::post('/withdraw-confirm/{id}', 'Admin\PayoutRecordController@payoutConfirm')->name('payout-confirm');
        Route::post('/withdraw-cancel/{id}', 'Admin\PayoutRecordController@payoutCancel')->name('payout-cancel');


        /* ===== Support Ticket ====*/
        Route::get('tickets/{status?}', 'Admin\TicketController@tickets')->name('ticket');
        Route::get('tickets/view/{id}', 'Admin\TicketController@ticketReply')->name('ticket.view');
        Route::put('ticket/reply/{id}', 'Admin\TicketController@ticketReplySend')->name('ticket.reply');
        Route::get('ticket/download/{ticket}', 'Admin\TicketController@ticketDownload')->name('ticket.download');
        Route::post('ticket/delete', 'Admin\TicketController@ticketDelete')->name('ticket.delete');

        /* ===== Subscriber =====*/
        Route::get('subscriber', 'Admin\SubscriberController@index')->name('subscriber.index');
        Route::post('subscriber/remove', 'Admin\SubscriberController@remove')->name('subscriber.remove');
        Route::get('subscriber/send-email', 'Admin\SubscriberController@sendEmailForm')->name('subscriber.sendEmail');
        Route::post('subscriber/send-email', 'Admin\SubscriberController@sendEmail')->name('subscriber.mail');


        /* ===== website controls =====*/
        Route::any('/basic-controls', 'Admin\BasicController@index')->name('basic-controls');
        Route::post('/basic-controls', 'Admin\BasicController@updateConfigure')->name('basic-controls.update');

        Route::match(['get', 'post'], 'currency-exchange-api-config', 'Admin\BasicController@currencyExchangeApiConfig')->name('currency.exchange.api.config');

        Route::any('/email-controls', 'Admin\EmailTemplateController@emailControl')->name('email-controls');
        Route::post('/email-controls', 'Admin\EmailTemplateController@emailConfigure')->name('email-controls.update');
        Route::post('/email-controls/action', 'Admin\EmailTemplateController@emailControlAction')->name('email-controls.action');
        Route::post('/email/test', 'Admin\EmailTemplateController@testEmail')->name('testEmail');

        Route::get('/email-template', 'Admin\EmailTemplateController@show')->name('email-template.show');
        Route::get('/email-template/edit/{id}', 'Admin\EmailTemplateController@edit')->name('email-template.edit');
        Route::post('/email-template/update/{id}', 'Admin\EmailTemplateController@update')->name('email-template.update');

        /*========Sms control ========*/
        Route::match(['get', 'post'], '/sms-controls', 'Admin\SmsTemplateController@smsConfig')->name('sms.config');
        Route::post('/sms-controls/action', 'Admin\SmsTemplateController@smsControlAction')->name('sms-controls.action');
        Route::get('/sms-template', 'Admin\SmsTemplateController@show')->name('sms-template');
        Route::get('/sms-template/edit/{id}', 'Admin\SmsTemplateController@edit')->name('sms-template.edit');
        Route::post('/sms-template/update/{id}', 'Admin\SmsTemplateController@update')->name('sms-template.update');

        Route::get('/notify-config', 'Admin\NotifyController@notifyConfig')->name('notify-config');
        Route::post('/notify-config', 'Admin\NotifyController@notifyConfigUpdate')->name('notify-config.update');
        Route::get('/notify-template', 'Admin\NotifyController@show')->name('notify-template.show');
        Route::get('/notify-template/edit/{id}', 'Admin\NotifyController@edit')->name('notify-template.edit');
        Route::post('/notify-template/update/{id}', 'Admin\NotifyController@update')->name('notify-template.update');


        /* ===== ADMIN Language SETTINGS ===== */
        Route::get('language', 'Admin\LanguageController@index')->name('language.index');
        Route::get('language/create', 'Admin\LanguageController@create')->name('language.create');
        Route::post('language/create', 'Admin\LanguageController@store')->name('language.store');
        Route::get('language/{language}', 'Admin\LanguageController@edit')->name('language.edit');
        Route::put('language/{language}', 'Admin\LanguageController@update')->name('language.update');
        Route::delete('language/{language}', 'Admin\LanguageController@delete')->name('language.delete');
        Route::get('/language/keyword/{id}', 'Admin\LanguageController@keywordEdit')->name('language.keywordEdit');
        Route::put('/language/keyword/{id}', 'Admin\LanguageController@keywordUpdate')->name('language.keywordUpdate');
        Route::post('/language/importJson', 'Admin\LanguageController@importJson')->name('language.importJson');
        Route::post('store-key/{id}', 'Admin\LanguageController@storeKey')->name('language.storeKey');
        Route::put('update-key/{id}', 'Admin\LanguageController@updateKey')->name('language.updateKey');
        Route::delete('delete-key/{id}', 'Admin\LanguageController@deleteKey')->name('language.deleteKey');

        Route::get('/logo-seo', 'Admin\BasicController@logoSeo')->name('logo-seo');
        Route::put('/logoUpdate', 'Admin\BasicController@logoUpdate')->name('logoUpdate');
        Route::put('/seoUpdate', 'Admin\BasicController@seoUpdate')->name('seoUpdate');
        Route::get('/breadcrumb', 'Admin\BasicController@breadcrumb')->name('breadcrumb');
        Route::put('/breadcrumb', 'Admin\BasicController@breadcrumbUpdate')->name('breadcrumbUpdate');


        /* ===== ADMIN TEMPLATE SETTINGS ===== */
        Route::get('template/{section}', 'Admin\TemplateController@show')->name('template.show');
        Route::put('template/{section}/{language}', 'Admin\TemplateController@update')->name('template.update');
        Route::get('contents/{content}', 'Admin\ContentController@index')->name('content.index');
        Route::get('content-create/{content}', 'Admin\ContentController@create')->name('content.create');
        Route::put('content-create/{content}/{language?}', 'Admin\ContentController@store')->name('content.store');
        Route::get('content-show/{content}/{name?}', 'Admin\ContentController@show')->name('content.show');
        Route::put('content-update/{content}/{language?}', 'Admin\ContentController@update')->name('content.update');
        Route::delete('contents/{id}', 'Admin\ContentController@contentDelete')->name('content.delete');

        Route::get('push-notification-show', 'SiteNotificationController@showByAdmin')->name('push.notification.show');
        Route::get('push.notification.readAll', 'SiteNotificationController@readAllByAdmin')->name('push.notification.readAll');
        Route::get('push-notification-readAt/{id}', 'SiteNotificationController@readAt')->name('push.notification.readAt');
        Route::match(['get', 'post'], 'pusher-config', 'SiteNotificationController@pusherConfig')->name('pusher.config');
    });

});


Route::match(['get', 'post'], 'success', 'PaymentController@success')->name('success');
Route::match(['get', 'post'], 'failed', 'PaymentController@failed')->name('failed');
Route::match(['get', 'post'], 'payment/{code}/{trx?}/{type?}', 'PaymentController@gatewayIpn')->name('ipn');


Route::get('/allSports/{categoryId?}', 'GameFetchController@index')->name('allSports');


Route::get('/language/{code?}', 'FrontendController@language')->name('language');


Route::get('/blog-details/{slug}/{id}', 'FrontendController@blogDetails')->name('blogDetails');
Route::get('/blog', 'FrontendController@blog')->name('blog');

Route::get('/', 'FrontendController@index')->name('home');
Route::get('/category/{category_slug}/{category_id}', 'FrontendController@category')->name('category');
Route::get('/tournament/{tournament_name}/{tournament_id}', 'FrontendController@tournament')->name('tournament');
Route::get('/match/{match_name}/{match_id}', 'FrontendController@match')->name('match');
Route::get('/about', 'FrontendController@about')->name('about');
Route::get('/faq', 'FrontendController@faq')->name('faq');


Route::get('/contact', 'FrontendController@contact')->name('contact');
Route::post('/contact', 'FrontendController@contactSend')->name('contact.send');

Route::post('/subscribe', 'FrontendController@subscribe')->name('subscribe');

Route::get('/{getLink}/{content_id}', 'FrontendController@getLink')->name('getLink');




