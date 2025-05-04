# New Pram Spa Booking System

Basic outline of different aspects of the code you may need to understand before starting development.
# Before You Start

## Prerequisite Knowledge
1. Go through tech document that was provided during handover.
2. Familiarise yourself with:
    1. MVC framework
    2. [CakePHP](https://book.cakephp.org/5/en/index.html)
    3. phpMyAdmin
    4. [composer](https://getcomposer.org/doc)
    5. [XAMPP](https://apachefriends.org/faq_windows.html) (for windows)

## Quick Setup
1. Check that you have linked the database to the code. This can be found in `config/app_local.php`.
2. Ensure that the Content Blocks table is populated within the database.
3. Ensure that composer is installed / up-to-date using:
``` bash
composer install

OR

composer update
```
___
# APIs and Plugins Used
## Google Maps Embed API
[Google Maps Embed API](https://developers.google.com/maps/documentation/embed/get-started) was used in the `selectLocation` function found in `Bookings`. This was used to show the customer where a location is on a map.

## Stripe API
[Stripe API](https://docs.stripe.com/api) was used in the `checkout` function found in `Bookings`. This was used to handle secure payments.

## Cake Authentication Plugin
[Cake Authentication Plugin](https://book.cakephp.org/4/en/tutorials-and-examples/cms/authentication.html) was used throughout the system to handle access control and separation between customers, admins, managers, and contractors.

## UGIE CakeHP Content Blocks Plugin
[UGIE Cake Content Blocks Plugin](https://github.com/ugie-cake/cakephp-content-blocks) was used to handle website customisation and simple content changes to customer emails.
___
# Main Features
## Bookings

### Bookings Controller

The `BookingsController` located in `src/Controller/BookingsController.php` handles the customer-related operations. Here you will find functions related to the booking functionality of the system.

Here are the key methods:

- **`initialize`**:
  - Allows `selectLocation`, `selectServices`, `coleectCustomerDetails`, `selectDropoffTime`, `confirm`, `privacyPolicy`, and `successPage` to be accessed without being logged-in to the system.


- **`index()`**:
    - Lists `Customer`, `Location`, `Drop-off Date & Time`, `Services`, `Due Date`, `Status`, `Assigned Contractor`, `Actions`.


- **`indexById()`**:
    - Redirects a user to the correct index views based on their role.


- **`assignContractor()`**:
  - Allows a manager or admin to assign a booking to a contractor, sending an email notification to said contractor.


- **`confirm()`**
  - Allows a customer to confirm the details of their booking before directing them to the `checkout()` function.


- **`checkout()`**
  - Redirects the user to the Stripe payment page.


- **`successPage()`**
  - Once a booking has been paid, booking details and customer details will be saved to the database.
  - Email is sent to customer and admin to inform them of a new booking


- **`monthlySummary()`**
  - Produces a financial summary based on the month. (Viewable only by Admin role)


- **`executiveSummary()`**
    - Produces a financial summary based on location, only taking into account completed bookings.


- **`allowEntry()`**
  - Can be used in a function to limit their accessibility only to admins and managers.

### BookingsProducts Controller
Controls adding and removing products from a booking.

### BookingsServices Controller
Controls adding and removing services from a booking.

## Locations
### Locations Controller
- **`add()`**
  - Create a new location.
  - Takes Google longitude and latitude for location data (Google Maps).
  - Availabilities (business hours) need to be listed separately by day.
  - Lunch breaks can be accounted for by making multiple 'time blocks' for a given day (i.e: Monday 9am-12pm, Monday 1pm-5pm)

- **`archive()`**
  - Due to data integrity needs, locations cannot be deleted.
  - They are marked as archived and removed from regular view.
  - Can be viewed and unarchived from the `indexArchived`.

### LocationsUsers Controller
- A user can be assigned to >= 0 locations.
- Users can be assigned to a location through the `template/users/edit`.


### Unavailabilities Controller
- When a location won't be operating during a given time (outside the agreed business hours), unavailability needs to be set.
- Can be done in `template/locations/edit`.


- **`add()`**
  - Set a date range when the location will not be accepting any orders.
  - Customers will not be able to make a booking at the location during the set time period.
## Photos

### BookingsPhotos Controller
- **`add()`**
    - Functionality to upload a photo to a specific booking.
    - Only allows files up to 5MB.
    - Only allows photo MIME types (jpg, jpeg, png).

### Photos Controller
- **`delete()`**
  - Hard deletes a photo from the filepath of the system.


- **`restore()`**
    - Moves a photo out of the bin and back to the booking it was uploaded to.


- **`movetoBin()`**
  - Soft deletes the photo from a booking and moves it to the bin to be deleted later.


- **`beforeFilter()`**
  - Limits registered users to be the only ones able to use the Photos functionality.



