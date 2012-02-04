During a recent interview I was asked to describe how I'd create an algorithm which would search through a grid and count the number of groups (or blocks) of marked cells within a grid.

The rules for a group being formed is that an active cell must have an active cell directly connected to one of its sides (i.e. a diagonal connection does not count).

I thought I'd code this up just out of interest to see how quickly and easily it could be acheived. Output from blocks.php looks like the following:

```
··■···■·■·■·■■·■■■■■
■····■·■··■··■·■··■·
■■·■■■·■■··■■■■■··■■
·■·■■■·■···■···■·■■■
·■·■··■■··■■···■■■·■
··■·■··■■■■·■····■··
······■·····■■■■■·■■
·■··■·■········■■·■·
■·■■■■·■■·■·■·····■·
··■■······■···■····■
·····■■·■·■··■■·■···
■··■·······■■■·■····
··■·■■·■■■■■■■■·■■■·
····■·······■··■■··■
■···■■■■■·······■···
■■··■··■·■··■·■■··■■
■■■·■■·■··■■·■··■·■·
·■····■·■······■·■··
··■·■··■■··■·■■·■■■·
■■■·····■■·■■··■·■■■

There are 47 blocks within this grid
```

The above is a 20 x 20 grid. The code runs as follows:

1. Grid is generated to planned size and with provided probability of a cell being active (where 0 = no chance of being active, 1 = cell always active).

2. Block counter traverses the entire grid looking for active cells and then recursively spiders from an active cell looking for connected active cells. If found it will continue to spider from that cell. One cells are checked they are marked as such so that multiple checks are not made. A parent level active cell once spidering has completed is then added to the block count.

To Run:
===========

There are two output methods from this code which can be used to see how it works:

1. Run `php blocks.php` this will output to the console using the \Grid\Display\Console writer.

2. Run `php blocks-browser.php <output_file>` to generate a HTML file with a better visual display of the data.

Tests:
==========

PHPUnit is used to run the unit tests for the code. Navigate to the tests folder and run `phpunit` to run the test suite.
