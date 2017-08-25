# go_to_prod


<strong>Move to Production Check List</strong>

plug-in for REDCap Version > 7.3.0

One of the most time consuming and repetitive tasks for REDCap administrators is the review of 'Move to Production' requests. This step is critical to ensure proper database design and validation
before data collection begins. If not done well, both small and large mistakes can jeopardize the quality of all subsequent work in the project. We constructed a plugin that enforces best practices and modifies
the 'Move to Production' workflow. Initial results suggest a dramatic reduction in common design mistakes while also significantly reducing the REDCap administrator support burden.

<strong><u>With this plugin, you can run the following checklist in the data dictionary of a REDCap database.</u></strong>
<ol>
    <li>Not recommended coding of "other" and/or "unknown" values in drop-down lists, radio-buttons or check-boxes.</li>
    <li>Inconsistencies in coding for yes/no questions.</li>
    <li>Inconsistencies in coding for positive/negative questions. </li>
    <li>No fields tagged as identifiers.</li>
    <li>Missing PI name and last name.</li>  
    <li>IRB Information.</li> 
    <li>Purpose of the project.</li> 
    <li>Date format inconsistencies.</li> 
    <li>Branching logic inconsistencies.</li> 
    <li>Inconsistencies in calculated fields.</li> 
    <li>Variable names with the same name as an event name.</li> 
    <li>"My First Instrument" form name presence.</li> 
    <li>% of validated fields.</li> 
    <li>Forms with more fields than recommended.</li> 
    <li>Forms not assigned to any event.</li> 
    <li>Calculations using "Today".</li> 
    <li>The project is sufficiently tested (at least three test records and 1 data export).</li> 
    <li>Inconsistencies in ASI Logic.</li> 
    <li>Inconsistencies in Data Quality Module Logic.</li> 
    <li>Inconsistencies in Advanced Reports Logic.</li> 
</ol>

# See in action 
[![IMAGE ALT TEXT HERE](/gotoprod.gif?raw=true "Check list Example")](https://youtu.be/zsoDnBT21jA)
https://youtu.be/zsoDnBT21jA 

## Installation instructions:
<ol>
    <li>Go to GitHub https://github.com/aandresalvarez/go_to_prod. </li>
    <li>Clone or download repository (Green button) </li>
    <li>Paste the unzipped folder in your /redcap/plugins/ folder.  </li>
    <li>Now your folder looks like this: /redcap/plugins/go_to_prod-master.</li>
    <li>Rename the folder from “go_to_prod-master” to “go_prod”.</li>
    <li>Now the plugin is ready for accessing.</li>
    <li>In a browser open https://yourredcapinstallation/plugins/go_prod/index.php?pid=XX, replace XX with the Project ID             for the project   you want to check.</li>
    <li> Optional: Set a project bookmark with the link.</li>
</ol>

<strong>Note 1:</strong> The REDCap go to production workflow is not affected by installing this plugin. To change the workflow, it is necessary to build your own hook. 
<strong>Note 2:</strong>  Metrics are not automatically captured. This requires the creation of an extra REDCap project and configuration.

All feedback is well received! Hope this helps.
