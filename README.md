# PointsMachine
Library to build Points Systems for MySql.

#Overview
PointsMachine allows user defined rule systems that can be configured though values stored in database. 

PointsMachine does not provide the GUI but is a set of classes that will manage the processing and storage of rules and scores.

A points run starts with a selection of scores that are then applied to a formula defined as a series of rule groups chain together with each group containg one to many adjustment rules that either modify or multiply the base score. These scorce can then be rounded and capped.  


#Concepts Overview:

##Period of Validity.
Many of the entities (Rules,Scores,Chains) all have a period of applicability. This library does not allow for future data only current. For example a delete operation will cause an existing entity to be closed meaning the databse record is not removed only its valid date range changed. If new entity is added it is active from that date. 

##Systems and Zones
All Formulas and Rules are linked to a System if you are running multiple reward schemes they would each belong to a different system. 

A System has Zones these zones should be mutually exclusive to each other for example sales territories. These zones are used to further filter which rules should apply to a score. 


## Score and Score Groups
A Score is a starting point each score has a value. This value will be modified by the processor.

You may have many scores in calculation run each score is modified independently. 

Each Score may belong to a single Score Group. 

Each product in your catelog could be assigned its own score with product categories making up the score groups.

## Adjustment Rules and Adjustment Groups
An adjustment rule contains a modifier and a multipler they can be:
1. Linked to specific system zones.
2. Linked to only a single Adjustment Group.

A rule multipler is a multiplication operation.
A rule modifier is a addition operation.


An Adjustment Group is a container for one or more Adjustment Rules.

A group has the following functions.
1. Be linked to only apply on specific Score Groups (different groups for each product category)
2. Be linked to one more Points Systems. (reuse one group across multiple point systems)
3. Have a maximum and minimum multipler and modifier (based on combined value of adjustment rules applied in the run)
4. Group can me made to be mandatory (always apply its rules)
5. Limit on number of adjustment rules that are applied to score (limit to a single rule).
6. Change how the linked rules are ordered (max or min).

For example you can have an adjustment group apply only a single largest rule from those included in a calculation run.



> If you developing a system and do not need the end user to configure the values through a GUI I would recommend that avoid using a library like mine.



