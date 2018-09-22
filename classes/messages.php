<?php
/**
 * LANGUAGE FILE
 *  here you can change the text content of the plugin
 *
 */
//Validation Labels



/**
 * @param $phrase
 * @return mixed
 */

//TODO: the names of the columns in the view files and the close button are hard coded.. create lang variables them.
function lang($phrase){
        static $lang = array(
            'OTHER_OR_UNKNOWN_TITLE' => '"99" or "98" coding recommended for "other" and/or "unknown" values in drop-down lists, radio-buttons or check-boxes.',
            'OTHER_OR_UNKNOWN_BODY' =>'<div class="overflow">It is common to include an "other" or "unknown" option at the end of a dropdown list. It is encouraged to use different coding for these answers (in general other=99 and unknown=98). There are two reasons for this: <p>1. You can easily add additional choices without needing to recode your values; and 2. when you are using statistical software it is apparent which values correspond to special codes. For example, the following is NOT recommended: </p><small><ul class="list-group" style=" padding-left: 50px; width: 215px; "><li class="list-group-item">1, Dr. Jones</li><li class="list-group-item">2, Dr. Parker </li><li class="list-group-item">3, Dr. Smith</li><li class="list-group-item">4, Other </li></ul></small><p>Say you have collected data for 100 records and you now want to add Dr. Rose to the list. A common mistake is the following: </p><small><ul class="list-group" style=" padding-left: 50px; width: 215px; "><li class="list-group-item">1, Dr. Jones</li><li class="list-group-item">2, Dr. Parker </li><li class="list-group-item">3, Dr. Smith</li><li class="list-group-item">4, Dr. Rose <br><strong>(DON\'T DO IT THIS WAY)</strong></li><li class="list-group-item">5, Other</li></ul></small><p>If, before the change, you had 20 records as \'other\' with a value of 4, they would all instantly be transferred to Dr. Rose. This usually isn\'t what is intended. A better design is something like: </p><small><ul class="list-group" style=" padding-left: 50px; padding-top: 0px; width: 215px; "><li class="list-group-item">1, Dr. Jones</li><li class="list-group-item">2, Dr. Parker </li><li class="list-group-item">3, Dr. Smith</li><li class="list-group-item">99, Other</li></ul></small><p>Now you can add additional members to the list during the project without needing to recode. And, when you analyze your data the other value is easily identified.</p></div>',
            'YES_NO_TITLE'=>'Inconsistencies in coding for yes/no questions.',
            'YES_NO_BODY' => 'When data is analyzed in statistical software you often only see the \'coded\' values.  So, it is important to be consistent across your project so the codes don\'t arbitrarily change from question to question.  In REDCap, the standard for \'Yes\' is 1 and \'No\' is 0.  If you select the Yes/No question type this is how it will be coded.
                        You should avoid using values other than 0 or 1 for No and Yes. Order doesn\'t matter. If you want the Yes option to come first, you can make your radio button fields as: <ul class="list-group" style=" padding-left: 50px; width: 150px; "><li class="list-group-item">1, Yes</li><li class="list-group-item">0, No</li><li class="list-group-item">99, Other</li></ul>',

            'POSITIVE_NEGATIVE_TITLE' =>'Inconsistencies in coding for positive/negative questions.',
            'POSITIVE_NEGATIVE_BODY' =>'When data is analyzed in statistical software you often only see the \'coded\' values.  So, it is important to be consistent across your project so the codes don\'t arbitrarily change from question to question.',

            'IDENTIFIERS_TITLE' =>'No fields tagged as identifiers.',
            'IDENTIFIERS_BODY' =>'<div class="alert alert-danger" role="alert">All fields with protected health information (PHI) should be marked as identifiers</div>',

            'PI_TITLE' =>'Missing PI name and last name.',
            'PI_BODY' =>'For a research project the name of the principal investigator (PI) is required. Please add it in the "Modify project title, purpose, etc." button under the Project Setup-> Modify project title, purpose, etc. -> Name of P.I. (if applicable):.',

            'IRB_TITLE' =>'IRB Information is not complete.',
            'IRB_BODY' =>'For a research project the Institutional Review Board (IRB) Number is required. Please add it in the "Modify project title, purpose, etc." button under the Project Setup',

            'RESEARCH_PROJECT_TITLE' => 'The purpose of this project is "<u>Not Research.</u>"',

            'RESEARCH_PROJECT_BODY' => 'It is not necessary to move this project into production mode since it is <u>not for research purposes.</u>  There are NO additional features that are enabled when moving to production.  You can test and even collect data in development mode.',

            'JUST_FOR_FUN_PROJECT_TITLE' => 'The purpose of this project is "<u>Practice/Just for Fun.</u>"',
            'JUST_FOR_FUN_PROJECT_BODY' => 'There is no reason to move this project into production mode.  There are NO additional features that are enabled when moving to production. You can test and even collect data in development mode. If this is a research project, please change the purpose of the project: <br> <strong>1.</strong> Go to Project Setup.<br> <strong>2.</strong> Click on the "Modify project title, purpose, etc.." button located in the panel named "Modify Project Settings". <br> <strong>3.</strong> Change the purpose of the project.',

            'DATE_CONSISTENT_TITLE' => 'Date format inconsistencies.',
            'DATE_CONSISTENT_BODY' => 'Your project uses different date formats (i.e, mix of mdy and ymd). <strong> You should validate consistently across all dates.</strong> When data is analyzed in statistical software you often only see the unformatted values.  So, it is important to be consistent across your project so the date formats don\'t arbitrarily change from question to question. For example, May 1, 2012 could be formatted as MDY (05-01-2012) or DMY (01-05-2012). Naively, this could be interpreted as both May 1, 2012 AND January 5, 2012 ',

            'BRANCHING_LOGIC_TITLE' => 'Branching logic inconsistencies.',

            'BRANCHING_LOGIC_BODY' => 'Some fields listed in your branching logic do not exist in this project and thus cannot be used. These fields must be removed from the branching logic before you can continue.',

            'CALCULATED_FIELDS_TITLE' => 'Inconsistencies in calculated fields.',
            'CALCULATED_FIELDS_BODY' => 'Some <strong>fields names or event names</strong> listed in your calculated fields do not exist in this project and thus cannot be used. These fields must be removed from your calculations before you can continue.',

            'VAR_NAMES_EVENT_NAMES_TITLE' => 'Variable names with the same name as an event name.',

            'VAR_NAMES_EVENT_NAMES_BODY' => 'Some of your field names are the same as an event name, this can create confusion. if this is non intentional please change the name of the variables.',

            'TEST_RECORDS_TITLE' => 'This project has not been sufficiently tested.',
            'TEST_RECORDS_BODY' => 'We recommend the creation of at least <strong>three</strong> test records and at least <strong>one</strong> export in development mode. This allows you to preview the type of results expected from your project. It is also highly recommended that you review your project\'s design with a statistician prior to entering production mode to ensure your data capture is configured properly.',

            'READY_TO_GO_TITLE' => ' You are all set!. ',
            'READY_TO_GO_BODY' => 'Looks like you are ready to move this project to production mode!.',

            'MY_FIRST_INSTRUMENT_TITLE' => '"My First Instrument" form name found. ',
            'MY_FIRST_INSTRUMENT_BODY' => 'You will see one default form already present in your "Online Designer," entitled “My First Instrument.” You may rename this form by clicking the “Rename” button to the right of the form name.',

            'NUMBER_VALIDATED_RECORDS_TITLE' => 'Very few validated text fields.',
            'NUMBER_VALIDATED_RECORDS_BODY' => 'Field validation helps to ensure the integrity of your collected data. Every form designer is strongly encouraged to take advantage of this REDCap functionality in order to discover errors during the data entry process and resolve these errors before they are saved to the database. Field validation only applies when the Field Type is a Text Box (Short Text).',

            'MAX_NUMBER_OF_RECORDS_TITLE' => 'Forms with more fields than recommended.',
            'MAX_NUMBER_OF_RECORDS_BODY' => 'It is recommended that each form has a maximum of<strong> 100 fields</strong> to optimize its performance; however, it is okay to have more fields if necessary.',

            'NOT_DESIGNATED_FORMS_TITLE' => 'Forms not assigned to any event.',
            'NOT_DESIGNATED_FORMS_BODY' => ' One or more instruments are not assigned to any event. No data will be collected on these instruments if they are not assigned to events in the <strong>Designate Instruments for My Events</strong> page.',

            'CALCULATED_TODAY_TITLE' => 'Calculations using "Today".',
            'CALCULATED_TODAY_BODY' => 'It is strongly recommended, that you do not use "today" in calc fields. This is because every time you access and save the form, the calculation will run. So if you calculate the age as of today, then a year later you access the form to review or make updates, the elapsed time as of "today" will also be updated (+1 yr). Most users calculate time off of another field (e.g. screening date, enrollment date).',

            'ASI_LOGIC_TITLE' => 'Problems found in ASI logic.',
            'ASI_LOGIC_BODY' => 'Some fields listed in your Automated Surveys Invitation (ASI) logic do not exist in this project and thus cannot be used.',
            'QUEUE_LOGIC_TITLE' => 'Problems found in the Survey Queue logic.',
            'QUEUE_LOGIC_BODY' => 'Some fields listed in your Survey Queue logic do not exist in this project and thus cannot be used.',

            'DATA_QUALITY_LOGIC_TITLE' => 'Problems found in the Data Quality Module logic.',
            'DATA_QUALITY_LOGIC_BODY' => 'Some fields listed in your Data Quality Module logic do not exist in this project and thus cannot be used.',

            'REPORTS_LOGIC_TITLE' => 'Problems found in some of your Reports Advanced Filter Logic.',
            'REPORTS_LOGIC_BODY' => 'Some fields listed in your Reports Advanced Filter Logic do not exist in this project and thus cannot be used.',


            'WARNING' => 'Warning',
            'DANGER' => 'Danger',
            'INFO' => 'Info',
            'SUCCESS' => 'Success',
            'VIEW' => 'View',
            'EDIT' => 'Edit',
            'PROJECT_SETUP' => 'Project Setup',
            'PROJECT_GO_PROD' => 'Project Setup',
            'USER_RIGHTS' => 'Sorry, only users who CAN edit this project are allowed to run this plugin.',
            'LOADING' => 'Loading...',
            'WIKI' => 'Wiki Page',
            'VALIDATION' => 'Issues that you may need to fix',
            'RESULT' => 'Type',
            'OPTIONS' => 'Options',
            'RUN' => 'Run Check List',
            'YES' => 'Yes',
            'NO' => 'No',
            'CLOSE' => 'Close',
            'NOTICE' => 'Notice',
            'INFO_WHAT_NETX' => 'What happens Next?',
            'INFO_WHAT_NETX_BODY' => '  Your project will be reviewed by SCCI before being moved into Production. This process typically takes 1-2 business days.  Can\'t wait? Click <a href="https://medwiki.stanford.edu/x/SRMzAw"><u>HERE</u></a>.',
            'INFO_WHAT_NETX_BODY_2' => ' If, on the next page you check \'Delete ALL Data\', any data entered before being approved for Production will be deleted. Do not enter production data while a request is pending unless you uncheck this box and follow the instructions in the next item.',
            'INFO_CITATION' => 'Citation Information',
            'INFO_CITATION_BODY' => ' REDCap at Stanford is supported by Research IT. All research resulting from the use of REDCap must cite the grants that make this service available - details, including biolerplate language, are located
                <a href="https://medwiki.stanford.edu/x/AAJPB"><u>HERE</u></a>.',
            'INFO_STATISTICIAN_REVIEW' => 'Statistician Review',
            'INFO_STATISTICIAN_REVIEW_BODY' => 'It is also highly recommended that you review your project\'s design with a statistician prior to entering production mode to ensure your data capture is configured properly.',

            'I_AGREE_BODY' => 'Click \'I Agree\' to signify all the pertinent issues above  were solved and the project is ready to go to production mode:',
            'I_AGREE' => 'I Agree',

            'VALIDATED_FIELDS' => 'Validated Fields:',
            'TEXT_BOX_FIELDS' => 'Text Box Fields:',
            'LOADING_EXTRA_TIME' => '<strong>Wow, what a large database!</strong><br> - It will take some extra time while all the Data Dictionary is analyzed. Please be patient :)',

            'PRODUCTION_WARNING' => '<div class="alert alert-warning alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Warning!</strong> This plugin may not work as expected in <strong style=\'color: green\'>Production</strong> mode. For better results, move back to <strong>Development</strong> mode.</div>',
            'VERSION_INFO' => '<div class="alert alert-warning alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Warning!</strong> This plugin may not work as expected in <strong style=\'color: green\'>REDCap versions less than  7.3.0</strong> After being on any page for more than 3 minutes, it would disable certain jQuery-enabled triggers, such as auto-complete drop-down fields on data entry forms and any custom Bootstrap components.</div>',
            'TITLE' => 'Move to Production Check List',
            'MAIN_TEXT' => 'If the thought of losing the data you have entered into your REDCap project sounds painful, you should be in production mode. Production mode helps protect your data from accidental mistakes. This plugin will allow you to verify if your project is ready to move to production mode or if you first need to fix something.  <a href="https://medwiki.stanford.edu/x/SRMzAw" > <u>When do I move to Production Mode?</u></a>'





        );

        return $lang[$phrase];
    }



