# go_to_prod


<strong>Move to Production Check List</strong>

plug-in for REDCap Version > 7.3.0

One of the most time consuming and repetitive tasks for REDCap administrators is the review of 'Move to Production' requests. This step is critical to ensure proper database design and validation
before data collection begins. If not done well, both small and large mistakes can jeopardize the quality of all subsequent work in the project. We constructed a plugin that enforces best practices and modifies
the 'Move to Production' workflow. Initial results suggest a dramatic reduction in common design mistakes while also significantly reducing the REDCap administrator support burden.

<strong><u>With this plugin, you can run the following checklist in the data dictionary of a REDCap database.<u/></strong>
<ul>
  <li>1.Not recommended coding of "other" and/or "unknown" values in drop-down lists, radio-buttons or check-boxes.</li>
  <li>2.Inconsistencies in coding for yes/no questions.</li>
  <li>3.Inconsistencies in coding for positive/negative questions. </li>
    <li>4. No fields tagged as identifiers.</li>
    <li>5. Missing PI name and last name.  </li>  
  
  <li>6. IRB Information.  </li> 
<li>7. Purpose of the project. </li> 
       <li>8. Date format inconsistencies. </li> 
        <li>9. Branching logic inconsistencies.  </li> 
         <li>10. Inconsistencies in calculated fields.  </li> 
          <li>11. Variable names with the same name as an event name.  </li> 
           <li>12. "My First Instrument" form name presence.  </li> 
            <li>13. % of validated fields.  </li> 
             <li>14. Forms with more fields than recommended.  </li> 
              <li>15. Forms not assigned to any event.  </li> 
               <li>16. Calculations using "Today".  </li> 
                <li>17. The project is sufficiently tested (at least three test records and 1 data export)  </li> 
                <li>18. Inconsistencies in ASI Logic  </li> 
                 <li>19. Inconsistencies in Data Quality Module Logic  </li> 
                <li>20. Inconsistencies in Advanced Reports Logic  </li> 
</ul>

### See in action
![Example](/gotoprod.gif?raw=true "Check list Example")
