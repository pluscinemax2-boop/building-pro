# Building Admin Pages Documentation

## Table of Contents
1. [Dashboard](#dashboard)
2. [Resident Management](#resident-management)
3. [Manager Management](#manager-management)
4. [Emergency Alerts](#emergency-alerts)
5. [Complaints](#complaints)
6. [Expenses](#expenses)
7. [Flat Management](#flat-management)
8. [Notices](#notices)
9. [Polls](#polls)
10. [Documents](#documents)
11. [Reports](#reports)
12. [Subscription](#subscription)
13. [Profile](#profile)
14. [Building Settings](#building-settings)
15. [Support](#support)

---

## Dashboard
**Route:** `/building-admin/dashboard`

### Main Fields:
- Building Name
- Subscription Tier
- Subscription Expiry

### Sub-sections:
- **Metrics Grid:**
  - Total Flats
  - Total Residents
  - Open Complaints (Highlighted)
  - Monthly Expenses

- **Quick Actions:**
  - Add Resident
  - New Notice
  - Reports
  - Log Expense

- **Recent Activity:**
  - Activity logs with timestamps

---

## Resident Management
**Route:** `/building-admin/resident-management`

### Main Fields:
- Search Bar
- Filter Chips (All, Active, Inactive)
- Resident List with Name, Status, Flat Number, Phone

### Sub-pages:
1. **Resident List Tab:**
   - Resident Name
   - Status (Occupied/Vacant/Active/Inactive)
   - Flat Number (Block-Number format)
   - Phone Number
   - Edit Button

2. **Resident Call Directory Tab:**
   - Resident Name
   - Flat Number (Block-Number format)
   - Phone Number
   - Call Button (with tel: link)
   - Export CSV button

### Sub-sections:
- **Filter Options:** All, Active, Inactive
- **Search Functionality:** Search by resident details
- **Export CSV:** Exports Flat Number, Name, Mobile Number

---

## Manager Management
**Route:** `/building-admin/manager-management`

### Main Fields:
- Search Bar
- Filter Chips (All, Active, Inactive)
- Manager List with Name, Status, Email, Phone

### Sub-pages:
1. **Manager List:**
   - Manager Name
   - Status (Active/Inactive)
   - Email Address
   - Phone Number
   - Edit Button

2. **Create Manager:**
   - Full Name
   - Email
   - Phone
   - Status (Active/Inactive)

3. **Edit Manager:**
   - Full Name
   - Email
   - Phone
   - Status (Active/Inactive)

### Sub-sections:
- **Filter Options:** All, Active, Inactive
- **Search Functionality:** Search by manager details
- **Create Manager Button:** Fixed action button at bottom

---

## Emergency Alerts
**Route:** `/building-admin/emergency`

### Main Fields:
- Search Bar
- Filter Options (Draft, Scheduled, Sent)
- Alert List with Title, Priority, Status, Date

### Sub-pages:
1. **Emergency Alerts List:**
   - Title
   - Message
   - Priority Level (Low, Medium, High)
   - Alert Type (Fire, Medical, Security, Weather, Other)
   - Status (Draft, Scheduled, Sent)
   - Scheduled Date/Time
   - Sent Date/Time

2. **Create Emergency Alert:**
   - Title
   - Message
   - Priority Level (Low, Medium, High)
   - Alert Type (Fire, Medical, Security, Weather, Other)
   - Status (Draft, Scheduled, Sent)
   - Scheduled Date/Time (for scheduled alerts)

3. **Edit Emergency Alert:**
   - Same fields as create but editable

### Sub-sections:
- **Filter Options:** Draft, Scheduled, Sent
- **Search Functionality:** Search by alert details
- **Create Alert Button:** Fixed action button at bottom

---

## Complaints
**Route:** `/building-admin/complaints`

### Main Fields:
- Search Bar
- Filter Options (All, Open, In Progress, Resolved)
- Complaint List with Title, Status, Priority, Date

### Sub-pages:
1. **Complaints List:**
   - Title
   - Description
   - Status (Open, In Progress, Resolved)
   - Priority (Low, Medium, High)
   - Submitted Date
   - Resident Name

2. **Create Complaint:**
   - Title
   - Description
   - Priority Level
   - Category
   - Assigned To

3. **View Complaint:**
   - Full complaint details
   - Status updates
   - Comments/Notes

### Sub-sections:
- **Filter Options:** All, Open, In Progress, Resolved
- **Search Functionality:** Search by complaint details

---

## Expenses
**Route:** `/building-admin/expenses`

### Main Fields:
- Search Bar
- Filter Options (All, Pending, Approved, Rejected)
- Expense List with Title, Amount, Date, Status

### Sub-pages:
1. **Expenses List:**
   - Title/Description
   - Amount
   - Date
   - Category
   - Status (Pending, Approved, Rejected)
   - Vendor/Supplier

2. **Create Expense:**
   - Title
   - Description
   - Amount
   - Date
   - Category
   - Vendor/Supplier
   - Receipt/Image Upload

3. **Edit Expense:**
   - Same fields as create but editable

### Sub-sections:
- **Filter Options:** All, Pending, Approved, Rejected
- **Search Functionality:** Search by expense details
- **Budget Management:** View and manage budgets

---

## Flat Management
**Route:** `/building-admin/flat-management`

### Main Fields:
- Search Bar
- Filter Options (All, Occupied, Vacant)
- Flat List with Block, Number, Status, Residents

### Sub-pages:
1. **Flat List:**
   - Block
   - Flat Number
   - Status (Occupied/Vacant)
   - Residents Count
   - Floor Number

2. **Create Flat:**
   - Block
   - Flat Number
   - Floor
   - Area (sq ft)
   - Type (1BHK, 2BHK, 3BHK, etc.)
   - Status

3. **Edit Flat:**
   - Same fields as create but editable

### Sub-sections:
- **Filter Options:** All, Occupied, Vacant
- **Search Functionality:** Search by flat details

---

## Notices
**Route:** `/building-admin/notices`

### Main Fields:
- Search Bar
- Filter Options (All, Active, Expired)
- Notice List with Title, Date, Status

### Sub-pages:
1. **Notices List:**
   - Title
   - Description
   - Date Posted
   - Expiry Date
   - Status (Active/Expired)
   - Category

2. **Create Notice:**
   - Title
   - Description
   - Date Posted
   - Expiry Date
   - Category
   - Target Audience

3. **Edit Notice:**
   - Same fields as create but editable

### Sub-sections:
- **Filter Options:** All, Active, Expired
- **Search Functionality:** Search by notice details

---

## Polls
**Route:** `/building-admin/polls`

### Main Fields:
- Search Bar
- Filter Options (All, Active, Closed)
- Poll List with Title, Status, Date

### Sub-pages:
1. **Polls List:**
   - Title
   - Description
   - Status (Active/Closed)
   - Start Date
   - End Date
   - Total Votes

2. **Create Poll:**
   - Title
   - Description
   - Options
   - Start Date
   - End Date
   - Target Audience

3. **Edit Poll:**
   - Same fields as create but editable

### Sub-sections:
- **Filter Options:** All, Active, Closed
- **Search Functionality:** Search by poll details

---

## Documents
**Route:** `/building-admin/documents`

### Main Fields:
- Search Bar
- Filter Options (All, Categories)
- Document List with Name, Type, Date, Category

### Sub-pages:
1. **Documents List:**
   - Document Name
   - Type/Category
   - Upload Date
   - File Size
   - Description

2. **Upload Document:**
   - File Upload
   - Document Name
   - Category
   - Description
   - Access Permissions

### Sub-sections:
- **Filter Options:** By category
- **Search Functionality:** Search by document details
- **File Management:** Upload, Download, Delete

---

## Reports
**Route:** `/building-admin/reports`

### Main Fields:
- Various report types with download options

### Sub-pages:
1. **Financial Reports:**
   - Monthly Expenses Report
   - Maintenance Collections Report
   - Category-wise Expenses Report
   - Budget vs Actual Report
   - Outstanding Dues Report
   - Vendor Payments Report

2. **Operational Reports:**
   - Complaints Summary Report
   - Amenity Usage Report

### Sub-sections:
- **Report Categories:** Financial, Operational
- **Download Options:** Various formats (PDF, CSV)

---

## Subscription
**Route:** `/building-admin/subscription`

### Main Fields:
- Current Plan Details
- Expiry Date
- Payment History

### Sub-pages:
1. **Subscription Overview:**
   - Current Plan Name
   - Expiry Date
   - Features List
   - Payment Status

2. **Plan Selection:**
   - Available Plans
   - Features Comparison
   - Pricing

### Sub-sections:
- **Plan Management:** Upgrade, Renew
- **Payment Processing:** Checkout, History

---

## Profile
**Route:** `/building-admin/profile`

### Main Fields:
- Personal Information
- Contact Details
- Profile Picture
- Security Settings

### Sub-pages:
1. **Profile Overview:**
   - Name
   - Email
   - Phone
   - Profile Picture
   - Role

2. **Edit Profile:**
   - Name
   - Email
   - Phone
   - Profile Picture Upload

3. **Security Settings:**
   - Password Change
   - Two-Factor Authentication
   - Login History

### Sub-sections:
- **Profile Management:** Edit, Update
- **Security:** Password, 2FA

---

## Building Settings
**Route:** `/building-admin/building-settings`

### Main Fields:
- Building Information
- Contact Details
- Profile Picture
- Address Information

### Sub-pages:
1. **Building Information:**
   - Building Name
   - Address
   - Country, State, City, ZIP
   - Emergency Contact

2. **Building Profile:**
   - Profile Picture Upload
   - Building Description
   - Amenities

### Sub-sections:
- **Information Management:** Update building details
- **Image Upload:** Building profile picture

---

## Support
**Route:** `/building-admin/support`

### Main Fields:
- FAQ Section
- Live Chat Widget

### Sub-pages:
1. **FAQ Section:**
   - Common Questions
   - Answers
   - Categories

2. **Live Chat:**
   - Real-time support
   - Message history
   - Support staff availability

### Sub-sections:
- **Help Resources:** FAQ, Documentation
- **Support Channels:** Chat, Contact

---

## Navigation Structure

### Bottom Navigation:
- **Home:** Dashboard access
- **Complaints:** Complaints management
- **Add Action:** Quick actions (Add Resident, Add Expense, Emergency Alert, Upload)
- **Expenses:** Expenses management
- **More:** Additional options (Alerts, Subscription, Flats, Residents, Documents, Reports, Polls, Profile, Support, Logout)

### More Menu (Grid Layout):
- **Alerts:** Emergency alerts
- **Subscription:** Subscription management
- **Flats:** Flat management
- **Residents:** Resident management
- **Documents:** Document management
- **Reports:** Reports access
- **Polls:** Polls management
- **Profile:** Profile management
- **Support:** Support access
- **Logout:** Sign out option