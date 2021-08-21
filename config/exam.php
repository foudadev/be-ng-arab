<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Exam Levels
    |--------------------------------------------------------------------------
    |
    | Here are each of exam level with exam configuration.
    |
    | hints:Number of hints offered to user per exam
    |
    | exam-period:Period of the exam per minutes
    |
    | *-questions:Questions structure
    |
    | hard-restriction-degree: degree which user get hard restriction on that category if user scored lower then it.
    |
    | passing-degree:degree which if user scored it or higher user considered passed the exam
    |
    | restriction-period: period that user will be restricted from entering the exam (If user scored higher then
    | hard-restriction-degree but lower then passing-degree in the last exam he had in this category)
    |
    | hard-restriction-period: period that user will be restricted from entering the exam if he scored hard-restriction-degree or lower
    |
    |
    */


    'levels' => [

        'junior' => [

            'level' => 1,

            'hints' => 2,

            'exam-period' => 10,

            'junior-questions' => 20,

            'mid-senior-questions' => 0,

            'senior-questions' => 0,

            'expert-questions' => 0,

            'hard-restriction-degree' => 50,

            'passing-degree' => 85,

            'restriction-period' => 14,

            'hard-restriction-period' => 30,
        ],

        'mid-senior' => [

            'level' => 2,

            'hints' => 3,

            'exam-period' => 15,

            'junior-questions' => 10,

            'mid-senior-questions' => 20,

            'senior-questions' => 0,

            'expert-questions' => 0,

            'hard-restriction-degree' => 50,

            'passing-degree' => 85,

            'restriction-period' => 14,

            'hard-restriction-period' => 30,

        ],

        'senior' => [

            'level' => 3,

            'hints' => 4,

            'exam-period' => 20,

            'junior-questions' => 5,

            'mid-senior-questions' => 10,

            'senior-questions' => 25,

            'expert-questions' => 0,

            'hard-restriction-degree' => 50,

            'passing-degree' => 85,

            'restriction-period' => 14,

            'hard-restriction-period' => 30,

        ],

        'expert' => [

            'level' => 4,

            'hints' => 5,

            'exam-period' => 25,

            'junior-questions' => 0,

            'mid-senior-questions' => 5,

            'senior-questions' => 15,

            'expert-questions' => 30,

            'hard-restriction-degree' => 50,

            'passing-degree' => 85,

            'restriction-period' => 14,

            'hard-restriction-period' => 30,

        ],


    ],


];
