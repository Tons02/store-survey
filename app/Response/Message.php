<?php
namespace App\Response;

class Message
{
    //STATUS CODES
    const CREATED_STATUS = 201;
    const UNPROCESS_STATUS = 422;
    const DATA_NOT_FOUND = 404;
    const SUCESS_STATUS = 200;
    const DENIED_STATUS = 403;
    const CUT_OFF_STATUS = 409;

    //USER OPERATIONS
    const USER_SAVE = "User successfully save.";
    const LOGIN_USER = "Sucessfully login.";
    const USER_UPDATE = "User successfully updated.";
    const USER_DISPLAY = "User display successfully.";
    
    //ROLE OPERATIONS
    const ROLE_SAVE = "Role successfully save.";
    const ROLE_UPDATE = "Role successfully updated.";
    const ROLE_DISPLAY = "Role display successfully.";
    const ROLE_ALREADY_USE = "Unable to Archive, Role already in used!";

    //COMPANY OPERATIONS
    const COMPANY_SAVE = "Company Sync successfully.";
    const COMPANY_DISPLAY = "Company display successfully.";

    //DEPARTMENT OPERATIONS
    const DEPARTMENT_SAVE = "Department Sync successfully.";
    const DEPARTMENT_DISPLAY = "Department display successfully.";

    //ENGAGEMENT FORMS
    const STORE_SAVE = "Engagement form successfully save.";
    const STORE_UPDATE = "Engagement form updated successfully";
    const STORE_DISPLAY = "Engagement form display successfully";

    //OBJECTIVES OPERATIONS
    const OBJECTIVE_SAVE = "Objective successfully save.";
    const OBJECTIVE_UPDATE = "Objective successfully updated.";
    const OBJECTIVE_DISPLAY = "Objective display successfully.";

    //Strategy OPERATIONS
    const STRATEGY_SAVE = "Strategy successfully save.";
    const STRATEGY_UPDATE = "Strategy successfully updated.";
    const STRATEGY_DISPLAY = "Strategy display successfully.";

    //GLOBAL MESSAGE
    const INVALID_STATUS = "Invalid Status";
    const INVALID_ID = "Invalid ID";
    const NOT_FOUND = "Data not Found";
    const INVALID_ACTION = "Invalid action.";
    const ARCHIVE_STATUS = "Successfully archived.";
    const RESTORE_STATUS = "Successfully restore.";
    const LOGOUT_USER = "Logout Successfully";
    

}