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

### See in action
![Example](/gotoprod.gif?raw=true "Check list Example")
