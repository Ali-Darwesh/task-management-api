## Task Management Api

 Task Management api System is a software to manage a lettel company contain admin,manager for each department,employee to do tasks  create, show,update and delete tasks, and allowing users to do tasks assigned from managers or admins.

### Githup Link

- [githup link](https://github.com/Ali-Darwesh/task-management-api).
## API Testing with Postman
To test the API endpoints, you can use the Postman collection provided in the project. Find it at `postman/endpointTask4.postman_collection.json`.

## Create Laravel project with 
### Create the project and initialize it
- composer create-project --prefer-dist laravel/laravel Task-management-api
- git init
- git add .
- git commit -m ""

## Models
i use Fillable,guarded,
-    protected $primaryKey = 'task_id'
-    public $incrementing = true
-    protected $table = 'user_tasks'
-    public $timestamps = true
-   const CREATED_AT = 'created_on'
-   const UPDATED_AT = 'updated_on'
i use Accessors to format the due_date when retrieving
and Mutatorto ensure due_date is stored in the right format when setting

## Services
I make Services for create ,update and delete operations

### seeder
to create the admin account
## Controllers
In controllers I use all above to keep it in better look and clean code



