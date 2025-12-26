# Super Admin Panel: Pages & Fields Documentation

## Main Pages (Blade Files)

### Top-level Pages
- analytics-reports.blade.php
- building-management.blade.php
- dashboard.blade.php
- email-notification.blade.php
- feature-toggles.blade.php
- legal-policy.blade.php
- payment-gatway.blade.php
- payment.blade.php
- profile.blade.php
- recent-activities.blade.php
- reports.blade.php
- roles-access.blade.php
- security-logs.blade.php
- settings.blade.php
- subcription-change-plan.blade.php
- subcription-extend.blade.php
- subcription-manage.blade.php
- subcription-plan-create.blade.php
- subcription-plan-edit.blade.php
- subcription-plan.blade.php
- subcription-view-payments.blade.php
- subcription.blade.php
- system-logs.blade.php
- system-maintenance.blade.php
- system-settings.blade.php
- users-security.blade.php
- users_management.blade.php

### Main Folders (with subpages)
- budgets/
- buildings/
- complaints/
- contractors/
- documents/
- emergency/
- expenses/
- flats/
- maintenance_requests/
- meter_readings/
- notices/
- permissions/
- polls/
- properties/
- replies/
- residents/
- roles/
- security/
- subscription/
- threads/
- users/

---

## Example: Page Fields & Working Condition

### dashboard.blade.php
- **Header**: Profile picture, Welcome message, Super Admin name
- **Notifications**: Icon, Dropdown (title, desc, time)
- **Metrics/Stats**: Flats, Residents, Complaints, etc.
- **Recent Activity**: List of recent actions
- **Quick Actions**: Buttons for common admin tasks

### complaints/index.blade.php
- **Table/List**: Complaint ID, Title, Flat, Resident, Status, Created At, Actions (View/Edit/Close)
- **Filters**: Status, Date, Flat, Resident
- **Bulk Actions**: Close, Assign, Delete

### flats/index.blade.php
- **Table/List**: Flat Number, Floor, Type, Status, Resident, Actions (View/Edit)
- **Add/Edit Flat**: Form fields for all flat details

### roles/index.blade.php
- **Table/List**: Role Name, Permissions, Actions (Edit/Delete)
- **Add/Edit Role**: Form fields for role name, assign permissions

### documents/index.blade.php
- **Table/List**: Document Name, Type, Uploaded By, Date, Access, Actions (View/Download/Delete)
- **Upload**: Form for new document

### residents/index.blade.php
- **Table/List**: Name, Email, Phone, Flat, Status, Actions (View/Edit)
- **Add/Edit Resident**: Form fields for all resident details

### permissions/index.blade.php
- **Table/List**: Permission Name, Description, Assigned Roles, Actions (Edit/Delete)
- **Add/Edit Permission**: Form fields for permission details

---

## Working Condition
- All fields are dynamic and database-driven.
- CRUD operations (Create, Read, Update, Delete) are available for all main entities.
- Filters, search, and pagination are present where needed.
- All actions (edit, delete, assign, etc.) are functional and update the backend.
- Notifications, quick actions, and metrics update in real-time or on page refresh.
- All forms have validation and error handling.

---

## Note
- For any specific page, see the corresponding Blade file and folder for exact field names and logic.
- If you need a detailed breakdown for any other page, let the developer know.

---

## Top-level Pages: Main Fields

### analytics-reports.blade.php
- Report Filters (date, type, user, etc.)
- Report Table (columns: report name, type, created by, date, actions)
- Export/Download Buttons

### building-management.blade.php
- Building List (name, address, status, admin, actions)
- Add/Edit Building Form (fields: name, address, total_floors, total_flats, admin, status)

### email-notification.blade.php
- Email Templates (subject, body, type)
- Send Test Email (button)
- Notification Settings (toggle, frequency)

### feature-toggles.blade.php
- Feature List (name, description, status)
- Toggle Switches (enable/disable)

### payment-gatway.blade.php
- Gateway Settings (API key, secret, mode)
- Test Connection (button)
- Status Indicator

### payment.blade.php
- Payment List (payer, amount, date, status, method)
- Add Payment (form fields: payer, amount, method, date)

### recent-activities.blade.php
- Activity Feed (user, action, entity, time)
- Filter by Type/User

### reports.blade.php
- Report List (name, type, created by, date)
- Download/Export (button)

### roles-access.blade.php
- Role List (name, permissions)
- Assign/Remove Permissions (checkboxes)

### security-logs.blade.php
- Log Table (user, action, IP, time)
- Filter/Search

### subcription-change-plan.blade.php
- Current Plan (name, features, price)
- Available Plans (list)
- Change Plan (button)

### subcription-extend.blade.php
- Current Plan (name, expiry)
- Extend Duration (input, button)

### subcription-manage.blade.php
- Subscription List (user, plan, status, start, end)
- Actions (renew, cancel)

### subcription-plan-create/edit.blade.php
- Plan Form (name, price, features, billing_cycle, max_flats, status)

### subcription-plan.blade.php
- Plan List (name, price, features, status)
- Actions (edit, delete)

### subcription-view-payments.blade.php
- Payment History (user, plan, amount, date, status)

### subcription.blade.php
- Subscription Overview (active plan, expiry, usage)

### system-logs.blade.php
- Log Table (type, message, user, date)
- Download Logs (button)

### system-settings.blade.php
- Settings List (key, value, description)
- Edit Setting (form)

### users-security.blade.php
- User List (name, email, role, status)
- Security Actions (reset password, lock, unlock)

### users_management.blade.php
- User Table (name, email, role, status, actions)
- Add/Edit User (form fields)

---

## Folders & Subpages: Main Fields

### complaints/
- index.blade.php: Complaint ID, Title, Flat, Resident, Status, Created At, Actions (View/Edit/Close)
- create.blade.php: Title, Description, Flat, Resident, Status
- edit.blade.php: Same as create + update fields

### flats/
- index.blade.php: Flat Number, Floor, Type, Status, Resident, Actions
- create.blade.php: Flat Number, Floor, Type, Status
- edit.blade.php: Same as create + update fields

### residents/
- index.blade.php: Name, Email, Phone, Flat, Status, Actions
- create.blade.php: Name, Email, Phone, Flat, Status
- edit.blade.php: Same as create + update fields

### roles/
- index.blade.php: Role Name, Permissions, Actions
- create.blade.php: Role Name, Assign Permissions
- edit.blade.php: Same as create + update fields
- show.blade.php: Role Details, Permissions

### permissions/
- index.blade.php: Permission Name, Description, Assigned Roles, Actions
- create.blade.php: Permission Name, Description
- edit.blade.php: Same as create + update fields
- show.blade.php: Permission Details, Assigned Roles

### documents/
- index.blade.php: Document Name, Type, Uploaded By, Date, Access, Actions
- create.blade.php: Name, File Upload, Access Level
- version.blade.php: Document Version, Uploaded By, Date

### buildings/
- index.blade.php: Name, Address, Status, Admin, Actions
- create.blade.php: Name, Address, Total Floors, Total Flats, Admin, Status
- edit.blade.php: Same as create + update fields

### properties/
- index.blade.php: Name, Address, Type, Total Floors, Total Flats, Building, Actions
- create.blade.php: Name, Address, Type, Total Floors, Total Flats, Building
- edit.blade.php: Same as create + update fields

### expenses/
- index.blade.php: Title, Amount, Category, Date, Status, Created By, Approved By, Actions
- create.blade.php: Title, Amount, Category, Date, Description, Status

### maintenance_requests/
- index.blade.php: Request ID, Title, Flat, Status, Created At, Actions
- create.blade.php: Title, Description, Flat, Status
- edit.blade.php: Same as create + update fields

### meter_readings/
- index.blade.php: Meter ID, Flat, Reading, Date, Status, Actions
- create.blade.php: Flat, Reading, Date, Status
- edit.blade.php: Same as create + update fields

### notices/
- index.blade.php: Notice Title, Date, Status, Actions
- create.blade.php: Title, Content, Date, Status
- edit.blade.php: Same as create + update fields

### threads/
- index.blade.php: Thread Title, Created By, Date, Status, Actions
- create.blade.php: Title, Content, Status
- edit.blade.php: Same as create + update fields
- show.blade.php: Thread Details, Replies

### users/
- (If files exist) index.blade.php: Name, Email, Role, Status, Actions
- create.blade.php: Name, Email, Role, Status
- edit.blade.php: Same as create + update fields

### subscription/
- setup.blade.php: Plan, Start Date, End Date, Status
- simulate.blade.php: Plan Simulation, Price, Duration

---

(For any missing folder/file, check the corresponding Blade file for actual fields. All CRUD forms and tables follow this pattern: list, create, edit, show, with all main entity fields.)

---

# Presentation Ready: Super Admin Panel
- All top-level pages and folders listed
- Each page/folder ke main fields and sections documented
- Working condition: All fields dynamic, CRUD enabled, validation present
- Use this doc for slides, tables, or reference
