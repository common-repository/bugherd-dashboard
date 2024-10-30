=== Bugherd Dashboard ===
Contributors: drrobotnik
Donate link: http://github.com/drrobotnik/
Tags: bugherd, dashboard, widget, bug tracking
Requires at least: 3.5.1
Tested up to: 3.9.2
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The Bugherd Dashboard provides a client facing interface within WordPress to track the progress of the bugs that have been submitted.

== Description ==

Bugherd is an amazingly convenient way for users/clients to submit issues, or bugs that they've found on the website. It is however missing a client facing view for them to see the status of bugs submitted. The BugHerd Dashboard helps solve this.

= The Dashboard Widget =

Provides a quick and brief way to check the statuses of all submitted bugs.

== Installation ==

= Using The WordPress Dashboard =

1. Navigate to the 'Add New' in the plugins dashboard
2. Search for 'Bugherd Dashboard'
3. Click 'Install Now'
4. Activate the plugin on the Plugin dashboard
5. From the dashboard, hover over the top right corner of the widget and click "configure" when it appears.
6. Enter your BugHerd Project ID, and your account API credentials.
7. Optional: Check whether you'd like the Bugherd install script to be installed automatically.

= Uploading in WordPress Dashboard =

1. Navigate to the 'Add New' in the plugins dashboard
2. Navigate to the 'Upload' area
3. Select `bugherd-dashboard.zip` from your computer
4. Click 'Install Now'
5. Activate the plugin in the Plugin dashboard
6. From the dashboard, hover over the top right corner of the widget and click "configure" when it appears.
7. Enter your BugHerd Project ID, and your account API credentials.
8. Optional: Check whether you'd like the Bugherd install script to be installed automatically.

= Using FTP =

1. Download `bugherd-dashboard.zip`
2. Extract the `bugherd-dashboard` directory to your computer
3. Upload the `bugherd-dashboard` directory to the `/wp-content/plugins/` directory
4. Activate the plugin in the Plugin dashboard
5. From the dashboard, hover over the top right corner of the widget and click "configure" when it appears.
6. Enter your BugHerd Project ID, and your account API credentials.
7. Optional: Check whether you'd like the Bugherd install script to be installed automatically.

== Frequently Asked Questions ==

= Where do I find the API Key? =

Log into your BugHerd admin. Click the Settings tab, then General Settings. Your api Key is on the last part of this page.

= Where do I find the Prodject ID? =

The easiest way to find the Project ID is to go to the project in BugHerd. Look in the URL where it says something like: http://www.bugherd.com/projects/`XXXXX`/kanban. That number is your Project ID.


== Screenshots ==

1. Hover over the top right corner to configure the widget
![Hover over the top right corner to configure the widget](./assets/screenshot-1.jpg)

1. Enter your Project ID and API Key
![Enter your Project ID and API Key](./assets/screenshot-2.jpg)

1. View live statuses of submitted issues
![View live statuses of submitted issues](./assets/screenshot-3.png)

== Changelog ==

= 1.0 =
* Initial Release

== Upgrade Notice ==

= 1.0 =
Good to go!