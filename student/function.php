<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/capstone/shared/connection.php';

function getFaculty($user_id){
    $conn = connection();

    $sql = "SELECT JSON_UNQUOTE(JSON_EXTRACT(data, '$.courses[*].professor')) AS 
    `professor_names` FROM `student` WHERE `user_id` = $user_id";


}
?>


{
  "courses": [
    {
      "course_code": "MATH101",
      "course_name": "Introduction to Mathematics",
      "professor": "John Doe",
      "schedule": [
        {
          "day": "Monday",
          "time": "10:00 AM - 11:30 AM"
        },
        {
          "day": "Wednesday",
          "time": "10:00 AM - 11:30 AM"
        }
      ]
    },
    {
      "course_code": "PHYS201",
      "course_name": "Physics Fundamentals",
      "professor": "Jane Smith",
      "schedule": [
        {
          "day": "Tuesday",
          "time": "9:00 AM - 10:30 AM"
        },
        {
          "day": "Thursday",
          "time": "9:00 AM - 10:30 AM"
        }
      ]
    },
{
      "course_code": "CS200",
      "course_name": "Introduction to Programming",
      "professor": "David Smith",
      "schedule": [
        {
          "day": "Monday",
          "time": "2:00 PM - 3:30 PM"
        },
        {
          "day": "Wednesday",
          "time": "2:00 PM - 3:30 PM"
        }
      ]
    },
    {
      "course_code": "ART110",
      "course_name": "Introduction to Art",
      "professor": "Emily White",
      "schedule": [
        {
          "day": "Tuesday",
          "time": "3:00 PM - 4:30 PM"
        },
        {
          "day": "Thursday",
          "time": "3:00 PM - 4:30 PM"
        }
      ]
    }
  ]
}