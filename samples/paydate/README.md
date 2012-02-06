# Test Application

## Requirements

You are required to create a small command-line utility to help a fictional company determine the dates they need to pay salaries to their sales department. This company is handling their sales payroll in the following way:

*   Sales staff get a regular monthly fixed base salary and a monthly bonus.
*   The base salaries are paid on the last day of the month unless that day is a Saturday or a Sunday (weekend) in which case they are paid on the friday before.
*   On the 15th of every month bonuses are paid for the previous month, unless that day is a weekend. In that case, they are paid the first Wednesday after the 15th.

The output of the utility should be a CSV file, containing the payment dates for the remainder of this year. The CSV file should contain a column for the month name, a column that contains the salary payment date for that month, and a column that contains the bonus payment date.

## Setup

In order to get the code running the machine will require working copies of:

*   Zend Framework
*   PHPUnit
*   PHP >5.0

The path to Zend Framework may need to be set up in the file **setup.php** in the root directory of this project. Please add the framework's parent path to the include path list. This should be the only change required.

## Running the Code

In order to run the code visit the **src** directory and call:  
<pre>php payments.php &lt;file_name&gt;
</pre>

## Configuration

I have set up the payment configuration in the **src/configs/payments.ini** file. This will allow you to set up additional payment types and modify the payment types as set out in the test.

Below is an explanation of the parameters each config required:

<table>
  <thead>
    <tr>
      <th>
        Paramter
      </th>
      
      <th>
        Values
      </th>
      
      <th>
        Description
      </th>
    </tr>
  </thead>
  
  <tbody>
    <tr class="odd">
      <th>
        [Payment_Name]
      </th>
      
      <td>
        string
      </td>
      
      <td>
        Payment name
      </td>
    </tr>
    
    <tr class="even">
      <th>
        payday
      </th>
      
      <td>
        start|end|1-31
      </td>
      
      <td>
        Day of month upon which payment should be attempted
      </td>
    </tr>
    
    <tr class="odd">
      <th>
        weekend.allow
      </th>
      
      <td>
        true|false
      </td>
      
      <td>
        Whether payments can be made on weekends
      </td>
    </tr>
    
    <tr class="even">
      <th>
        weekend.move
      </th>
      
      <td>
        before|after
      </td>
      
      <td>
        If weekend clash found does the payment come before or after the clash) weekend.day = monday-friday (on which day the payment should then be made
      </td>
    </tr>
    
    <tr class="odd">
      <th>
        payshift
      </th>
      
      <td>
        integer
      </td>
      
      <td>
        Whether to shift the pay or not, e.g. in the case of bonus' these are paid the month after, could be the month before with -1)
      </td>
    </tr>
  </tbody>
</table>

## Tests

Tests can be found in the **tests** sub-directory, simply calling phpunit from that location will invoke the testsuite. Coverage reports and testdox can then be found in the **logs** subdirectory.
