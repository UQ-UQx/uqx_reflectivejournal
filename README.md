# UQx Reflective Journal LTI

![Image of UQx Reflective Journal](https://github.com/UQ-UQx/uqx_reflectivejournal/blob/master/uqx_reflectivejournal.png)

## Features
* Journal Entries can be embedded anywhere in LMS course.
* WYSIWYG Editor.
* Instructors can set export format. Both PDF and Microsoft Word are supported.
* Word Cloud can be enabled on journal entry screen.
* Word count limit can be displayed and is updated while learners count.
* Flexible admin setup to enable/disable all setting.
* Journal Entry review mode with the display of a review instruction.
* Export mode with display options (collapsed or inline) for multiple entries, export to PDF or Word and Word cloud.

## Installation
* Setup Mysql Database. The install/dbcreate.sql has the table creation statements.
* Rename config.php.example to config.php and enter database settings and LTI keys.

## LTI Setup on edX and Embedding Modes
1. Add Journal Entry Activity in edX
- Add an LTI Consumer in edX
- Add the following in Custom parameters: ["activity_id=-1", "activity_displaytype=learnerinput"]
- Save the LTI consumer_key. The Add Activity form will be displayed.
- Enter the title, intro text, feedback and other relevant setting. Click on the Save button. The Activity ID will be updated. Copy the activity ID and update the activity_id in the Custom Parameters eg
["activity_id=1", "activity_displaytype=learnerinput"]
2. Add a Review Journal Entry Activity
- Add an LTI Consumer in edX
- Refer to the activity_id that contains the Journal entry that must be reviewed and updated in the Custom parameters: ["activity_id=1", "activity_displaytype=showentry"]
3 Display a Summary and Export
- Add an LTI Consumer in edX
- Refer to the activity_id that contains the first Journal entry, set the activity_displaytype to results and set activities_to_include to a comma separated list of journal entries by activity_id in the Custom parameters: ["activity_id=1", "activity_displaytype=results", "activities_to_include=1,2,3"]
