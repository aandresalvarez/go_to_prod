<?php
/**
 * LANGUAGE FILE
 *  here you can change the text content of the plugin
 *
 */
//Validation Labels


    //TODO: Improve the styles  creating a css file.
/**
 * @param $phrase
 * @return mixed
 */
function lang($phrase){
        static $lang = array(
            'OTHER_OR_UNKNOWN_TITLE' => 'Incorrect Coding of "Other" and "Unknown" values in drop-down lists, radio-buttons or check-boxes.',
            'OTHER_OR_UNKNOWN_BODY' =>'It is common to include an \'other\' or \'unknown\' option at the end of a dropdown list. It is encouraged to use different coding for these answers for two reasons (in general Other=99 and unknown=98). <p>You can easily add additional choices without needing to recode your values When you are using statistical software it is apparent which values correspond to special codes, For example, the following is NOT recommended: </p><ul class="list-group" style=" padding-left: 50px; width: 250px; "><li class="list-group-item">1, Dr. Jones</li><li class="list-group-item">2, Dr. Parker </li><li class="list-group-item">3, Dr. Smith</li><li class="list-group-item">4, Other </li></ul><p>Say you have collected data for 100 records and you now want to add Dr. Rose to the list. A common mistake is the following: </p><ul class="list-group" style=" padding-left: 50px; width: 250px; "><li class="list-group-item">1, Dr. Jones</li><li class="list-group-item">2, Dr. Parker </li><li class="list-group-item">3, Dr. Smith</li><li class="list-group-item">4, Dr. Rose <strong>(DON\'T DO IT THIS WAY)</strong></li><li class="list-group-item">5, Other</li></ul><p>If, before the change, you had 20 records as \'other\' with a value of 4, they would all instantly be transferred to Dr. Rose. This usually isn\'t what is intended. A better design is something like: </p><ul class="list-group" style=" padding-left: 50px; width: 250px; "><li class="list-group-item">1, Dr. Jones</li><li class="list-group-item">2, Dr. Parker </li><li class="list-group-item">3, Dr. Smith</li><li class="list-group-item">99, Other</li></ul><p>Now you can add additional members to the list during the project without needing to recode. And, when you analyze your data the other value is easily identified.</p>',
            'YES_NO_TITLE'=>'Different coding for yes/no questions.',
            'YES_NO_BODY' => 'When data is analyzed in statistical software you often only see the \'coded\' values.  So, it is important to be consistent across your project so the codes don\'t arbitrarily change from question to question.  In REDCap, the standard for \'Yes\' is 1 and \'No\' is 0.  If you select the Yes/No question type this is now it will be coded.
                        You should avoid using values other than 0 or 1 for No and Yes. Order doesn\'t matter, so you can make your radio button fields as: <ul class="list-group" style=" padding-left: 50px; width: 150px; "><li class="list-group-item">1, Yes</li><li class="list-group-item">0, No</li><li class="list-group-item">99, Other</li></ul>If you want the Yes option to come first.',

            'POSITIVE_NEGATIVE_TITLE' =>'Different coding for Positive/Negative questions.',
            'POSITIVE_NEGATIVE_BODY' =>'When data is analyzed in statistical software you often only see the \'coded\' values.  So, it is important to be consistent across your project so the codes don\'t arbitrarily change from question to question.',

            'IDENTIFIERS_TITLE' =>'No fields tagged as identifiers were found.',
            'IDENTIFIERS_BODY' =>'<div class="alert alert-danger" role="alert">All fields with PHI should are marked as identifiers</div>',

            'PI_TITLE' =>'Missing PI name and last name.',
            'PI_BODY' =>'For a research project the name of the principal investigator is required. Please add it on  the "Modify project title, purpose, etc." button under the Project Setup-> Modify project title, purpose, etc. -> Name of P.I. (if applicable):.',

            'IRB_TITLE' =>'IRB Information is not complete.',
            'IRB_BODY' =>'For a research project the Institutional Review Board (IRB) Number is required. Please add it on  the "Modify project title, purpose, etc." button under the Project Setup',

            'RESEARCH_PROJECT_TITLE' => 'The purpose of this project is "<u>Not Research</u>".',

            'RESEARCH_PROJECT_BODY' => 'Is not necessary to move this project into production mode since is <u>Not Research</u>.  There are NO additional features that are enabled when moving to production.  You can test and even collect data in development mode.',

            'JUST_FOR_FUN_PROJECT_TITLE' => 'The purpose of this project is "<u>Practice/Just for Fun</u>".',
            'JUST_FOR_FUN_PROJECT_BODY' => 'There is no reason to move this project into production mode.  There are NO additional features that are enabled when moving to production.  You can test and even collect data in development mode.',

            'DATE_CONSISTENT_TITLE' => 'Date Format Inconsistencies.',
            'DATE_CONSISTENT_BODY' => 'Different date formats (i.e, mix of mdy and ymd) – validate consistently across all dates.',

            'BRANCHING_LOGIC_TITLE' => 'Branching Logic Inconsistencies.',
            'BRANCHING_LOGIC_BODY' => 'Some fields listed in your Branching logic do not exist in this project and thus cannot be used. These fields must be removed from the calculation equation before you can continue.',

            'TEST_RECORDS_TITLE' => 'This project has not been sufficiently tested.',
            'TEST_RECORDS_BODY' => 'We recommend the creation of least 3 test records and at least 1 export in development mode to be sure of the results. It is also highly recommended that you review your project\'s design with a statistician prior to entering production mode to ensure your data capture is configured properly.',

            'READY_TO_GO_TITLE' => ' You are all set!. ',
            'READY_TO_GO_BODY' => 'Looks like you are ready to move this project to Production mode!.',

            'NUMBER_VALIDATED_RECORDS_TITLE' => 'Very few validated text fields.',
            'NUMBER_VALIDATED_RECORDS_BODY' => 'Data Field Validation helps ensure the integrity of your collected data.  Every form designer is strongly encouraged to take advantage of this REDCap functionality in order to discover errors during the data entry process and resolve these errors before they are saved to the database. Field Validation only applies when the Field Type is a Text Box (Short Text).',

            'MAX_NUMBER_OF_RECORDS_TITLE' => 'Forms with more fields than the recommended ones',
            'MAX_NUMBER_OF_RECORDS_BODY' => 'It is recommended that each form has a maximum of<strong> 30 fields</strong> to optimize its performance, however it is okay to have more fields if necessary.',

            'WARNING' => 'Warning',
            'DANGER' => 'Danger',
            'INFO' => 'Info',
            'SUCCESS' => 'Success',
            'VIEW' => 'Details',
            'EDIT' => 'Edit',
            'PROJECT_SETUP' => 'Project Setup',
            'PROJECT_GO_PROD' => 'Project Setup',
            'USER_RIGHTS' => 'Sorry , just users who CAN edit this project are allowed to run this plugin.',
            'LOADING' => 'Loading...',
            'WIKI' => 'Wiki Page',


            'VALIDATED_FIELDS' => 'Validated Fields:',
            'TEXT_BOX_FIELDS' => 'Text Box Fields:',
            'LOADING_EXTRA_TIME' => '<strong>Wow! What a large database!</strong><br> - It will take some extra time while all the Data Dictionary is analyzed. Please be patient :)',

            'PRODUCTION_WARNING' => '<div class="alert alert-warning"><strong>Warning!</strong> This plugin may not work as is expected in <strong style=\'color: green\'>Production</strong> mode. For better results move back to <strong>Development</strong> mode.</div>',
            'TITLE' => 'Go to Production mode Check List',
            'MAIN_TEXT' => 'If the thought of loosing the data you have entered into your REDCap project sounds painful, then you should be in Production mode. Production mode helps protect your data from accidental mistakes. This plugin will allow you to verify if your project is ready to go to production or you ned to fix something before.  <a href="https://medwiki.stanford.edu/x/SRMzAw" > <u>When do I move to Production Mode?</u></a>'

        );

        return $lang[$phrase];
    }



