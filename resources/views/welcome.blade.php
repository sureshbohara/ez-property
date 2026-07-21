For future update changes:

git add .
git commit -m "Updated email marketing model"
git push



git commit -m "feat: Implement Dashboard, Chat System, and Saved Properties

- Added role-based Dashboard (Host/Guest) with Overview, Bookings, Reviews, and Settings tabs.
- Implemented real-time-like Chat/Messaging system with Unread count badges.
- Integrated Bookings into Chat (auto-create conversations for booked properties).
- Added Saved Properties (Wishlist) functionality with toggle heart icon.
- Fixed Chart.js rendering issues and Inertia form data handling.
- Optimized Eloquent queries for better performance."





resources/js/
├── app.jsx                      # Main entry point (Inertia setup)
├── bootstrap.js                 # Axios setup
│
├── Pages/                   
│    ├── Home.jsx                # Homepage
│    ├── PropertyDetails.jsx      # Property 
│    ├── Checkout.jsx            # Checkout page
│    ├── About.jsx               # About us page
│    ├── Contact.jsx             # Contact us page
│    ├── Login.jsx               # Login page
│    └── Register.jsx            # Register page
│
├── Layouts/                     # Page Wrappers (Header + Content + Footer)
│    ├── FrontLayout.jsx         # Main website ko layout (Logged in & Guest)
│    └── GuestLayout.jsx         # Login/Register ko lagi (No header/footer)
│
├── Components/                  #  Reusable UI components
│    ├── Shared/                 # Common UI parts
│    │    ├── Header.jsx
│    │    └── Footer.jsx
│    │
│    ├── HomeSections/           # Homepage specific sections
│    │    ├── SearchSection.jsx
│    │    ├── FilterSection.jsx
│    │    ├── FeaturedSection.jsx
│    │    ├── StaysNearSection.jsx
│    │    └── HomestaysSection.jsx,RecommendedSection.jsx,TrusSection.jsx,
     ├──PropertyDetails/
          - PropertyHeader.jsx,PropertyGallery,PropertyOverview,PropertyAmenities,PropertyCalendar,PropertyReviews,PropertyPolicies,BookingCard
│    │
│    ├── PropertyCard.jsx         # Property card (Use All Home Page or Other Page)
│
│
├── Utils/                       #  Helper functions & Constants
│    ├── helpers.js              # formatPrice(), formatDate()
│    └── constants.js            # Status codes, Roles, etc.
│
└── css/                         # Styling
└── app.css                 # Tailwind/CSS imports

app.blade.php is 

























