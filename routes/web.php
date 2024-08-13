<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\Analytics;
use App\Http\Controllers\dashboard\Dashboard;
use App\Http\Controllers\layouts\WithoutMenu;
use App\Http\Controllers\layouts\WithoutNavbar;
use App\Http\Controllers\layouts\Fluid;
use App\Http\Controllers\layouts\Container;
use App\Http\Controllers\layouts\Blank;
use App\Http\Controllers\AccountSettingsAccount;
use App\Http\Controllers\AccountSettingsNotifications;
use App\Http\Controllers\AccountSettingsConnections;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\pages\MiscUnderMaintenance;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\authentications\ForgotPasswordBasic;
use App\Http\Controllers\cards\CardBasic;
use App\Http\Controllers\CurriculoController;
use App\Http\Controllers\user_interface\Accordion;
use App\Http\Controllers\user_interface\Alerts;
use App\Http\Controllers\user_interface\Badges;
use App\Http\Controllers\user_interface\Buttons;
use App\Http\Controllers\user_interface\Carousel;
use App\Http\Controllers\user_interface\Collapse;
use App\Http\Controllers\user_interface\Dropdowns;
use App\Http\Controllers\user_interface\Footer;
use App\Http\Controllers\user_interface\ListGroups;
use App\Http\Controllers\user_interface\Modals;
use App\Http\Controllers\user_interface\Navbar;
use App\Http\Controllers\user_interface\Offcanvas;
use App\Http\Controllers\user_interface\PaginationBreadcrumbs;
use App\Http\Controllers\user_interface\Progress;
use App\Http\Controllers\user_interface\Spinners;
use App\Http\Controllers\user_interface\TabsPills;
use App\Http\Controllers\user_interface\Toasts;
use App\Http\Controllers\user_interface\TooltipsPopovers;
use App\Http\Controllers\user_interface\Typography;
use App\Http\Controllers\extended_ui\PerfectScrollbar;
use App\Http\Controllers\extended_ui\TextDivider;
use App\Http\Controllers\icons\MdiIcons;
use App\Http\Controllers\form_elements\BasicInput;
use App\Http\Controllers\form_elements\InputGroups;
use App\Http\Controllers\form_layouts\VerticalForm;
use App\Http\Controllers\form_layouts\HorizontalForm;
use App\Http\Controllers\tables\Basic as TablesBasic;
use App\Http\Controllers\ProfileController;
use App\Models\AppClient;
use App\Models\Purchase;
use App\Models\Service;
use Illuminate\Http\Client\Request;
use App\Livewire\Testes\Form as TesteForm;
use Illuminate\Support\Facades\Auth;

use function Sentry\captureException;

// Route::get('/logout', function () {
//     auth()->logout();
//     return redirect('/');
// })->name('logout');

Route::get('/', function () {
    return redirect(route('login'));
});

Route::get('/home', function () {
    if (Auth::user()->hasRole('candidate')) {
        return redirect(route('candidate.dashboard'));
    }
});

Route::get('/dashboard', function () {
    return redirect(route('filament.app.pages.dashboard'));
})->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/billing-portal', function (Request $request) {

        $request->user()->createOrGetStripeCustomer();

        return $request->user()->redirectToBillingPortal(route('filament.admin.pages.dashboard'));
    })->name('billing');
    Route::get('/testes/{slug}', TesteForm::class)->name('teste-form');
    Route::get('/redirect-auth/{name}', function (Request $request, string $name) {
        // $request->session()->put('state', $state = Str::random(40));

        $appClient = AppClient::where('name', $name)->first();

        $query = http_build_query([
            'client_id' => $appClient->id,
            'redirect_uri' => $appClient->redirect,
            'response_type' => 'code',
            'scope' => '',
            // 'state' => $state,
        ]);

        return redirect(route('passport.authoprizations.authorize', $query));
    })->name('redirect-auth');
    Route::get('/checkout/{service}', function (Request $request, string $service) {
        return $request->user()->checkout([$service => 1], [
            'success_url' => route('checkout-success') . '?session_id={CHECKOUT_SESSION_ID}' . '&service=' . $service,
            // 'cancel_url' => route('checkout-cancel'),
        ]);;
    })->name('checkout');
    Route::get('/checkout-success', function (Request $request) {
        $checkoutSession = $request->user()->stripe()->checkout->sessions->retrieve($request->get('session_id'));
        try {
            $service = Service::where('stripe_id', $request->get('service'))->first();
            // $user = User::where('stripe_id', $data['customer'])->first();
            $purchase = Purchase::create([
                'user_id' => $request->user()->id,
                'service_id' => $service->id,
                'total_amount' => $checkoutSession->amount_total,
                // 'purchase_date' => $checkoutSession->created,
            ]);
            // dd($purchase);
        } catch (\Exception $e) {
            captureException($e);
        }
        return view('checkout.success', ['checkoutSession' => $checkoutSession]);
    })->name('checkout-success');

    Route::prefix('c')->name('candidate.')->group(function () {
        Route::get('/', function () {
            return redirect(route('candidate.dashboard'));
        });
        Route::get('dashboard', [Dashboard::class, 'index'])->name('dashboard');
        Route::prefix('perfil')->name('profile.')->group(function () {
            Route::get('/', [AccountSettingsAccount::class, 'index'])->name('profile-settings');
            Route::get('notifications', [AccountSettingsNotifications::class, 'index'])->name('notifications');
            Route::get('connections', [AccountSettingsConnections::class, 'index'])->name('connections');
        });
        Route::prefix('curriculo')->name('curriculo.')->group(function () {
            Route::get('/', [CurriculoController::class, 'index'])->name('curriculo');
        });
    });
});

Route::prefix('demo')->group(function () {
    // Main Page Route
    Route::middleware('auth')->group(function () {
        Route::get('/', [Analytics::class, 'index'])->name('dashboard-analytics');
    });

    // layout
    Route::get('/layouts/without-menu', [WithoutMenu::class, 'index'])->name('layouts-without-menu');
    Route::get('/layouts/without-navbar', [WithoutNavbar::class, 'index'])->name('layouts-without-navbar');
    Route::get('/layouts/fluid', [Fluid::class, 'index'])->name('layouts-fluid');
    Route::get('/layouts/container', [Container::class, 'index'])->name('layouts-container');
    Route::get('/layouts/blank', [Blank::class, 'index'])->name('layouts-blank');

    // pages
    Route::get('/pages/account-settings-account', [AccountSettingsAccount::class, 'index'])->name('pages-account-settings-account');
    Route::get('/pages/account-settings-notifications', [AccountSettingsNotifications::class, 'index'])->name('pages-account-settings-notifications');
    Route::get('/pages/account-settings-connections', [AccountSettingsConnections::class, 'index'])->name('pages-account-settings-connections');
    Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');
    Route::get('/pages/misc-under-maintenance', [MiscUnderMaintenance::class, 'index'])->name('pages-misc-under-maintenance');

    // authentication
    Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');
    Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');
    Route::get('/auth/forgot-password-basic', [ForgotPasswordBasic::class, 'index'])->name('auth-reset-password-basic');

    // cards
    Route::get('/cards/basic', [CardBasic::class, 'index'])->name('cards-basic');

    // User Interface
    Route::get('/ui/accordion', [Accordion::class, 'index'])->name('ui-accordion');
    Route::get('/ui/alerts', [Alerts::class, 'index'])->name('ui-alerts');
    Route::get('/ui/badges', [Badges::class, 'index'])->name('ui-badges');
    Route::get('/ui/buttons', [Buttons::class, 'index'])->name('ui-buttons');
    Route::get('/ui/carousel', [Carousel::class, 'index'])->name('ui-carousel');
    Route::get('/ui/collapse', [Collapse::class, 'index'])->name('ui-collapse');
    Route::get('/ui/dropdowns', [Dropdowns::class, 'index'])->name('ui-dropdowns');
    Route::get('/ui/footer', [Footer::class, 'index'])->name('ui-footer');
    Route::get('/ui/list-groups', [ListGroups::class, 'index'])->name('ui-list-groups');
    Route::get('/ui/modals', [Modals::class, 'index'])->name('ui-modals');
    Route::get('/ui/navbar', [Navbar::class, 'index'])->name('ui-navbar');
    Route::get('/ui/offcanvas', [Offcanvas::class, 'index'])->name('ui-offcanvas');
    Route::get('/ui/pagination-breadcrumbs', [PaginationBreadcrumbs::class, 'index'])->name('ui-pagination-breadcrumbs');
    Route::get('/ui/progress', [Progress::class, 'index'])->name('ui-progress');
    Route::get('/ui/spinners', [Spinners::class, 'index'])->name('ui-spinners');
    Route::get('/ui/tabs-pills', [TabsPills::class, 'index'])->name('ui-tabs-pills');
    Route::get('/ui/toasts', [Toasts::class, 'index'])->name('ui-toasts');
    Route::get('/ui/tooltips-popovers', [TooltipsPopovers::class, 'index'])->name('ui-tooltips-popovers');
    Route::get('/ui/typography', [Typography::class, 'index'])->name('ui-typography');

    // extended ui
    Route::get('/extended/ui-perfect-scrollbar', [PerfectScrollbar::class, 'index'])->name('extended-ui-perfect-scrollbar');
    Route::get('/extended/ui-text-divider', [TextDivider::class, 'index'])->name('extended-ui-text-divider');

    // icons
    Route::get('/icons/icons-mdi', [MdiIcons::class, 'index'])->name('icons-mdi');

    // form elements
    Route::get('/forms/basic-inputs', [BasicInput::class, 'index'])->name('forms-basic-inputs');
    Route::get('/forms/input-groups', [InputGroups::class, 'index'])->name('forms-input-groups');

    // form layouts
    Route::get('/form/layouts-vertical', [VerticalForm::class, 'index'])->name('form-layouts-vertical');
    Route::get('/form/layouts-horizontal', [HorizontalForm::class, 'index'])->name('form-layouts-horizontal');

    // tables
    Route::get('/tables/basic', [TablesBasic::class, 'index'])->name('tables-basic');
});

require __DIR__ . '/auth.php';
