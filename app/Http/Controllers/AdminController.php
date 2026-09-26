<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\HomeContent;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // ----- Auth ----------------------

    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required',
        ]);

        $admin = Admin::where('username', $request->username)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            session(['admin_id' => $admin->id, 'admin_username' => $admin->username]);
            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Invalid username or password.');
    }

    public function logout()
    {
        session()->forget(['admin_id', 'admin_username']);
        return redirect()->route('admin.login');
    }
    public function showProfile()
    {
        $admin = Admin::find(session('admin_id'));
        return view('admin.profile', compact('admin'));
    }

    public function updateProfile(Request $request)
    {
        $admin = Admin::find(session('admin_id'));

        if (!$admin) {
            return redirect()->route('admin.login')->with('error', 'Session expired. Please log in again.');
        }

        $request->validate([
            'username' => 'required|string|max:100|unique:admins,username,' . $admin->id,
            'current_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:6|confirmed',
        ]);

        // Update username
        $admin->username = $request->username;
        session(['admin_username' => $admin->username]);

        // If changing password
        if ($request->filled('new_password')) {
            if (!$request->filled('current_password')) {
                return back()->with('error', 'Please enter your current password to set a new password.');
            }

            if (!Hash::check($request->current_password, $admin->password)) {
                return back()->with('error', 'Current password is incorrect. Please try again.');
            }

            $admin->password = Hash::make($request->new_password);
        }

        $admin->save();

        return back()->with('message', 'Account settings & password updated successfully!');
    }

    // ----------- Customers Management -----------
    public function customersIndex(Request $request)
    {
        $search = $request->query('search');
        $query = \App\Models\Signup::withCount('orders')->withSum('orders', 'total_amount')->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('First_name', 'LIKE', "%{$search}%")
                  ->orWhere('Last_name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        $customers = $query->paginate(15)->withQueryString();
        $totalCustomers = \App\Models\Signup::count();

        return view('admin.customers.index', compact('customers', 'totalCustomers', 'search'));
    }

    public function customerShow(\App\Models\Signup $customer)
    {
        $customer->load(['orders.items']);
        return view('admin.customers.show', compact('customer'));
    }

    // ----------- Contact Inquiries Inbox -----------
    public function contactsIndex(Request $request)
    {
        $search = $request->query('search');
        $query = \App\Models\Contact::latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('mobile', 'LIKE', "%{$search}%")
                  ->orWhere('message', 'LIKE', "%{$search}%");
            });
        }

        $contacts = $query->paginate(15)->withQueryString();
        $totalContacts = \App\Models\Contact::count();

        return view('admin.contacts.index', compact('contacts', 'totalContacts', 'search'));
    }

    public function contactDestroy(\App\Models\Contact $contact)
    {
        $contact->delete();
        return redirect()->route('admin.contacts.index')->with('message', 'Contact message deleted successfully.');
    }

    // ----------- Dashboard--------------------------
    public function dashboard()
    {
        $totalCustomers = \App\Models\Signup::count();
        $totalMessages = \App\Models\Contact::count();
        $totalProducts = \App\Models\Product::count();
        $totalOrders = \App\Models\Order::count();
        $totalRevenue = \App\Models\Order::where('status', 'completed')->sum('total_amount');
        $pendingOrders = \App\Models\Order::where('status', 'pending')->count();
        $recentOrders = \App\Models\Order::with('items')->latest()->take(5)->get();
        $lowStockProducts = \App\Models\Product::where('stock_quantity', '<=', 5)
            ->where('stock_quantity', '>', 0)
            ->orderBy('stock_quantity')
            ->take(5)
            ->get();
        $outOfStockCount = \App\Models\Product::where('stock_quantity', '<=', 0)->count();

        return view('admin.admindash', compact(
            'totalCustomers', 'totalProducts', 'totalOrders', 'totalMessages',
            'totalRevenue', 'pendingOrders', 'recentOrders', 'lowStockProducts', 'outOfStockCount'
        ));
    }

    // ------- Homepage Content (CMS) --------------------------------

    public function homepageIndex()
    {
        $sections = [
            'top_bar' => 'Top Bar',
            'hero' => 'Hero Banner',
            'welcome' => 'Welcome Section',
            'feature1' => 'Feature Card 1',
            'feature2' => 'Feature Card 2',
            'brand_banner' => 'Brand Banner',
            'shop_section' => 'Our Shop Section',
            'catalogue' => 'Catalogue Section',
            'testimonials' => 'Testimonials Section',
            'footer_contact' => 'Footer — Contact Info',
            'footer_subscribe' => 'Footer — Subscribe Text',
            'footer_social' => 'Footer — Social Media Links',
            'footer_copyright' => 'Footer — Copyright Text',
        ];

        $contents = HomeContent::whereIn('section', array_keys($sections))->get()->keyBy('section');

        return view('admin.homepage.index', compact('sections', 'contents'));
    }

    public function editSection(string $section)
    {
        $sectionLabels = [
            'top_bar' => 'Top Bar ',
            'hero' => 'Hero Banner',
            'welcome' => 'Welcome Section',
            'feature1' => 'Feature Card 1',
            'feature2' => 'Feature Card 2',
            'brand_banner' => 'Brand Banner',
            'shop_section' => 'Our Shop Section',
            'catalogue' => 'Catalogue Section',
            'testimonials' => 'Testimonials Section',
            'footer_contact' => 'Footer — Contact Info',
            'footer_subscribe' => 'Footer — Subscribe Text',
            'footer_social' => 'Footer — Social Media Links',
            'footer_copyright' => 'Footer — Copyright Text',
        ];

        if (!array_key_exists($section, $sectionLabels)) {
            abort(404);
        }

        $content = HomeContent::getSection($section);
        $label = $sectionLabels[$section];

        return view('admin.homepage.edit', compact('section', 'content', 'label'));
    }


    public function updateSection(Request $request, string $section)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:4096',
            // footer social
            'fb_url' => 'nullable|string|max:255',
            'tw_url' => 'nullable|string|max:255',
            'ig_url' => 'nullable|string|max:255',
            'li_url' => 'nullable|string|max:255',
            // footer contact
            'contact_email' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:100',
        ]);

        $row = HomeContent::firstOrNew(['section' => $section]);

        if ($section === 'footer_social') {
            $row->description = implode('|', [
                $request->input('fb_url', '#'),
                $request->input('tw_url', '#'),
                $request->input('ig_url', '#'),
                $request->input('li_url', '#'),
            ]);

        } elseif ($section === 'footer_contact') {
            $row->subtitle = $request->input('subtitle');
            $row->description = $request->input('contact_email', '') . '|' . $request->input('contact_phone', '');

        } else {
            $row->title = $request->input('title');
            $row->subtitle = $request->input('subtitle');
            $row->description = $request->input('description');
        }

        if ($request->hasFile('image')) {
            if ($row->image) {
                Storage::disk('public')->delete($row->image);
            }
            $row->image = $request->file('image')->store('cms', 'public');
        }

        $row->save();

        return redirect()->route('admin.homepage.index')
            ->with('message', 'Section updated successfully!');
    }

    public function editWelcome()
    {
        return redirect()->route('admin.homepage.edit', ['section' => 'welcome']);
    }

    public static function collectionSections(): array
    {
        return [
            'coll_banner' => 'Top Banner & Page Title',
            'coll_card1' => 'Top Section  Feature Card 1',
            'coll_card2' => 'Top Section  Feature Card 2',
            'coll_brand_banner' => 'Middle Brand Banner',
            'coll_card3' => 'Bottom Section Feature Card 1',
            'coll_card4' => 'Bottom Section  Feature Card 2',
        ];
    }
    public function collectionsIndex()
    {
        $sections = self::collectionSections();
        $contents = HomeContent::whereIn('section', array_keys($sections))->get()->keyBy('section');

        return view('admin.collections.index', compact('sections', 'contents'));
    }

    public function editCollectionSection(string $section)
    {
        $sections = self::collectionSections();

        if (!array_key_exists($section, $sections)) {
            abort(404);
        }

        $content = HomeContent::getSection($section);
        $label = $sections[$section];

        return view('admin.collections.edit', compact('section', 'content', 'label'));
    }

    public function updateCollectionSection(Request $request, string $section)
    {
        $sections = self::collectionSections();

        if (!array_key_exists($section, $sections)) {
            abort(404);
        }

        $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:4096',
        ]);

        $row = HomeContent::firstOrNew(['section' => $section]);
        $row->title = $request->input('title');
        $row->subtitle = $request->input('subtitle');
        $row->description = $request->input('description');

        if ($request->hasFile('image')) {
            if ($row->image) {
                Storage::disk('public')->delete($row->image);
            }
            $row->image = $request->file('image')->store('cms', 'public');
        }

        $row->save();

        return redirect()->route('admin.collections.index')
            ->with('message', 'Collections section updated successfully!');
    }

    // ---------- ABOUT SECTION CMS------------
    public static function aboutSections(): array
    {
        return [
            'about_banner' => 'Top Banner & Page Title',
            'about_story' => 'Our Story Section',
            'about_mission' => 'Our Mission Section',
            'about_vision' => 'Our Vision Section',
        ];
    }
    public function about_index()
    {
        $sections = self::aboutSections();
        $contents = HomeContent::whereIn('section', array_keys($sections))->get()->keyBy('section');
        return view('admin.about.index', compact('sections', 'contents'));
    }
    public function editaboutsection(string $section)
    {
        $sections = self::aboutSections();
        if (!array_key_exists($section, $sections)) {
            abort(404);
        }
        $content = HomeContent::getSection($section);
        $label = $sections[$section];
        return view('admin.about.edit', compact('section', 'content', 'label'));
    }
    public function updateaboutsection(Request $request, string $section)
    {
        $sections = self::aboutSections();
        if (!array_key_exists($section, $sections)) {
            abort(404);
        }
        $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:4096',
        ]);

        $row = HomeContent::firstOrNew(['section' => $section]);
        $row->title = $request->input('title');
        $row->subtitle = $request->input('subtitle');
        $row->description = $request->input('description');
        if ($request->hasFile('image')) {
            if ($row->image) {
                Storage::disk('public')->delete($row->image);
            }
            $row->image = $request->file('image')->store('cms', 'public');
        }
        $row->save();
        return redirect()->route('admin.about-us.index')
            ->with('message', 'About section updated successfully!');

    }

    // -------------- Journal Content (CMS) ---------------------------

    public static function journalSections(): array
    {
        return [
            'journal_banner' => 'Top Banner & Page Title',
            'journal_post1' => 'Article 1 Cooking & Techniques',
            'journal_post2' => 'Article 2 Recipes & Bakery',
            'journal_post3' => 'Article 3 Product Care & Use',
        ];
    }

    public function journal_index()
    {
        $sections = self::journalSections();
        $contents = HomeContent::whereIn('section', array_keys($sections))->get()->keyBy('section');

        return view('admin.journal.index', compact('sections', 'contents'));
    }

    public function editjournalsection(string $section)
    {
        $sections = self::journalSections();

        if (!array_key_exists($section, $sections)) {
            abort(404);
        }

        $content = HomeContent::getSection($section);
        $label = $sections[$section];

        return view('admin.journal.edit', compact('section', 'content', 'label'));
    }

    public function updatejournalsection(Request $request, string $section)
    {
        $sections = self::journalSections();

        if (!array_key_exists($section, $sections)) {
            abort(404);
        }

        $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:4096',
        ]);

        $row = HomeContent::firstOrNew(['section' => $section]);
        $row->title = $request->input('title');
        $row->subtitle = $request->input('subtitle');
        $row->description = $request->input('description');

        if ($request->hasFile('image')) {
            if ($row->image) {
                Storage::disk('public')->delete($row->image);
            }
            $row->image = $request->file('image')->store('cms', 'public');
        }

        $row->save();

        return redirect()->route('admin.journal.index')
            ->with('message', 'Journal section updated successfully!');
    }

    // -------------- Shop Page Content (CMS) ---------------------------

    public static function shopSections(): array
    {
        return [
            'shop_banner' => 'Shop Banner & Heading',
        ];
    }

    public function shop_index()
    {
        $sections = self::shopSections();
        $contents = HomeContent::whereIn('section', array_keys($sections))->get()->keyBy('section');

        return view('admin.shop.index', compact('sections', 'contents'));
    }

    public function editShopSection(string $section)
    {
        $sections = self::shopSections();

        if (!array_key_exists($section, $sections)) {
            abort(404);
        }

        $content = HomeContent::getSection($section);
        $label = $sections[$section];

        return view('admin.shop.edit', compact('section', 'content', 'label'));
    }

    public function updateShopSection(Request $request, string $section)
    {
        $sections = self::shopSections();

        if (!array_key_exists($section, $sections)) {
            abort(404);
        }

        $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:4096',
        ]);

        $row = HomeContent::firstOrNew(['section' => $section]);
        $row->title = $request->input('title');
        $row->subtitle = $request->input('subtitle');
        $row->description = $request->input('description');

        if ($request->hasFile('image')) {
            if ($row->image) {
                Storage::disk('public')->delete($row->image);
            }
            $row->image = $request->file('image')->store('cms', 'public');
        }

        $row->save();

        return redirect()->route('admin.shop.index')
            ->with('message', 'Shop page content updated successfully!');
    }

    // -------------- Contact Us Page Content (CMS) ---------------------

    public static function contactSections(): array
    {
        return [
            'contact_banner' => 'Top Banner & Page Title',
            'contact_header' => 'Contact Details Heading & Intro',
            'contact_location' => 'Location Address Card',
            'contact_phone' => 'Phone Numbers Card',
            'contact_email' => 'Email Addresses Card',
            'contact_form_intro' => 'Have A Question Form Header',
        ];
    }

    public function contact_index()
    {
        $sections = self::contactSections();
        $contents = HomeContent::whereIn('section', array_keys($sections))->get()->keyBy('section');

        return view('admin.contact.index', compact('sections', 'contents'));
    }

    public function editContactSection(string $section)
    {
        $sections = self::contactSections();

        if (!array_key_exists($section, $sections)) {
            abort(404);
        }

        $content = HomeContent::getSection($section);
        $label = $sections[$section];

        return view('admin.contact.edit', compact('section', 'content', 'label'));
    }

    public function updateContactSection(Request $request, string $section)
    {
        $sections = self::contactSections();

        if (!array_key_exists($section, $sections)) {
            abort(404);
        }

        $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:4096',
        ]);

        $row = HomeContent::firstOrNew(['section' => $section]);
        $row->title = $request->input('title');
        $row->subtitle = $request->input('subtitle');
        $row->description = $request->input('description');

        if ($request->hasFile('image')) {
            if ($row->image) {
                Storage::disk('public')->delete($row->image);
            }
            $row->image = $request->file('image')->store('cms', 'public');
        }

        $row->save();

        return redirect()->route('admin.contact-cms.index')
            ->with('message', 'Contact page content updated successfully!');
    }
}

