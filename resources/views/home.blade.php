<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel = "icon" href = "ap.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <title>Academe Access Admin</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .add-mask,.update-mask{
            position:fixed;
            justify-content:center;
            align-items:center;
            left:0;
            top:0;
            width:100%;
            height:100vh;
            display:flex;
            background-color:rgba(0,0,0,0.5);
            visibility:hidden;
        }
        .add-mask[data-visible="true"],.update-mask[data-visible="true"]{
            visibility:visible;   
        }
        /* Add padding to containers */
        form{
            position:relative;
            width:75%;
            z-index:102;
        }
        .container {
            padding: 16px;
            background:white;
        }

        /* Full-width input fields */
        input[type=text], input[type=password], input[type=file],textarea {
            width: 100%;
            padding: 15px;
            margin: 5px 0 22px 0;
            display: inline-block;
            border: none;
            background: #f1f1f1;
        }
        input[type=number],select{
            width:100%;
            padding:15px;
            margin:5px 0 22px 0;
            display:inline-block;
            border:none;
            background: #f1f1f1;
        }
        input[type=text]:focus, input[type=password]:focus {
            background-color: #ddd;
            outline: none;
        }

        /* Overwrite default styles of hr */
        hr {
            border: 1px solid #f1f1f1;
            margin-bottom: 25px;
        }

        /* Set a style for the submit register button */
        .registerbtn {
        background-color: #04AA6D;
        color: white;
        padding: 16px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
        opacity: 0.9;
        }

        .registerbtn:hover {
        opacity:1;
        }

        /* Add a blue text color to links */
        a {
        color: dodgerblue;
        }

        /* Set a grey background color and center the text of the "sign in" section */
        .signin {
        background-color: #f1f1f1;
        text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- nav bar section -->
        <nav class="nav">
            <a href="#" style="color:black; text-decoration:none;">Log Out</a>
        </nav>
        <div class="page-header">  
            <h1 class="h2">  List of Members<a class="btn btn-success" style="margin-left: 780px;"><span class="glyphicon glyphicon-user"></span>  Add Member</a></h1><hr>  
        </div>  
        <div class="add-mask" id="add-prompt" data-visible="false">
            <!-- Button trigger modal -->
            <!-- Modal for create function -->
            <form id="add-form">
                <div class="container">
                    <h1 style="display:flex; justify-content:space-between">
                        Add Employee
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-x-square close-mask" aria-controls="add-prompt" viewBox="0 0 16 16">
                        <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                        </svg>  
                    </h1>
                    <p>Please fill in the employee fields</p>
                    <hr>
                    <label for="uid"><b>User Id </b></label>
                    <input type="text" name="uid" id="uidInput">
                    <label for="firstname"><b>Firstname </b></label>
                    <input type="text" name="firstname" id="firstnameInput">
                    <label for="middlename"><b>Middlename (Optional)</b></label>
                    <input type="text" name="middlename" id="middlenameInput" >
                    <label for="lastname"><b>Lastname</b></label>
                    <input type="text" name="lastname" id="lastnameInput">
                    <label for="role"><b>Role</b></label>
                    <select name="role" id="roleInput">
                        <option>Faculty</option> 
                        <option>Staff</oaption>
                    </select>
                    <button type="submit" class="registerbtn">Add</button>
                </div>
            </form>
        </div>
         <div class="update-mask" id="update-prompt" data-visible="false">
            <!-- Button trigger modal -->
            <!-- Modal for update function -->
            <form id="update-form">
                <div class="container">
                    <h1 style="display:flex; justify-content:space-between">
                        Update Member
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-x-square close-update-mask" aria-controls="update-prompt" viewBox="0 0 16 16">
                        <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                        </svg>  
                    </h1>
                    <hr>
                    <label for="uid"><b>User Id </b></label>
                    <input type="text" name="uid" id="uidRead" value="">
                    <label for="firstname"><b>Firstname </b></label>
                    <input type="text" name="firstname" id="firstnameRead" value="">
                    <label for="middlename"><b>Middlename </b></label>
                    <input type="text" name="middlename" id="middlenameRead" value="">
                    <label for="lastname"><b>Lastname</b></label>
                    <input type="text" name="lastname" id="lastnameRead" value="">
                    <label for="role"><b>Role</b></label>
                    <input type="text" name="role" id="roleRead" value="">
                    <button type="submit" class="registerbtn">Update</button>
                </div>
            </form>
        </div>
        <div class="row"> 
        </div>  
    </div>
    <script>
        $(document).ready(()=>{
            displayMembers();
        });
        const addbtn=document.querySelector('.btn');
        const addPrompt=document.querySelector('#add-prompt');
        const addCloseBtn=document.querySelector('.close-mask');
        const updatePrompt=document.querySelector('#update-prompt');
        const updateCloseBtn=document.querySelector('.close-update-mask');
        updateCloseBtn.addEventListener('click',()=>{
            updatePrompt.setAttribute("data-visible","false");
        })
        addbtn.addEventListener('click',()=>{
           addPrompt.setAttribute("data-visible","true"); 
        });
        addCloseBtn.addEventListener('click',()=>{
            addPrompt.setAttribute("data-visible","false");
        });
        function displayMembers() {
            $.ajax({
                type: 'get',
                url: '/get-members',
                success: function (response) {
                    if (response.success) {
                        let data = response.data;
                        $('.row').empty();
                        for (let i = 0; i < data.length; i++) {
                            $('.row').append(
                                `<div class='col-3 text-center' id=${i}>`,
                            );
                            $(`#${i}`).append(
                                `<img src='${data[i].avatar}' style='border-radius:50%' width='250px' height='250px' /><hr>`,
                                `<h3 class='page-header' style='background-color:cadetblue; font-size:1.2rem; text-align: center;'>
                                    ${data[i].firstname} ${(data[i].middlename===null)?"":data[i].middlename} ${data[i].lastname}
                                    <br>
                                    ${data[i].role}
                                </h3>`,
                                `<p class='page-header' align='center'>`,
                                    `<span>`,
                                        `<a class='btn btn-primary' id='editBtn' onclick='showEditPrompt({uid:${data[i].uid},firstname:"${data[i].firstname}",middlename:"${data[i].middlename}",lastname:"${data[i].lastname}",role:"${data[i].role}"})'><span class='glyphicon glyphicon-pencil'></span> Edit</a>`,
                                        `<a class='btn btn-warning' id='deleteUidInput' title='click for delete' onclick='removeHandler("${data[i].role}","${data[i].uid}")'><span class='glyphicon glyphicon-trash'></span> Delete</a>`,
                                    `</span>`,
                                `</p>`
                            );
                        }
                    } else {
                        console.log("Failed to retrieve members data");
                    }
                },
                error: function (error) {
                    console.error("Get members request error: ", error);
                }
            });
         }
        function showEditPrompt({uid,firstname,middlename,lastname,role}){
            $("#uidRead").val(uid);
            $("#firstnameRead").val(firstname);
            $("#middlenameRead").val((middlename===null)?null:middlename);
            $("#lastnameRead").val(lastname);
            $("#roleRead").val(role);
            updatePrompt.setAttribute("data-visible","true") 
        }
        function addEmployee(field) {
            $.ajax({
                type: 'post',
                url: '/add-employee',
                data: field,
                success: function(response) {
                    if (response.success) {
                        console.log("Employee data stored!");
                        displayMembers();
                    } else {
                        console.log("Failed to store employee data!");
                    }
                },
                error: function(error) {
                    console.error("Employee request error: ", error);
                }
            });
        }
        function removeHandler(role,uidToDelete){
            let memberRole= role;
            if(memberRole=="Faculty"||memberRole=="Staff"){
                removeEmployee(uidToDelete);
            }
            else{
                removeStudent(uidToDelete);
            }
        }
        function removeEmployee(uidToDelete){
            $.ajax({
                type:'post',
                url:'/remove-employee',
                data:{
                    uid:uidToDelete
                },
                success: function(response){
                    if(response.success){
                        console.log("Employee data removed!");
                        displayMembers();
                    }else{
                        console.log("Failed to remove employee data!");
                    }
                },
                error: function(error){
                    console.error("Remove employee request error: ",error)
                }
            });
        }
        function removeStudent(uidToDelete){
            $.ajax({
                type:'post',
                url:'/remove-student',
                data:{
                    uid:uidToDelete
                },
                success: function(response){
                    if(response.success){
                        console.log("Student data removed!");
                        displayMembers();
                    }else{
                        console.log("Failed to remove student data!");
                    }
                },
                error: function(error){
                    console.error("Remove student request error: ",error)
                }
            });
        }

        function updateHandler(field){
           let memberRole=field.role;
           if(memberRole=="Faculty"||memberRole=="Staff"){
                updateEmployee(field);
           } 
           else{
                updateStudent(field);
           }
        }
        function updateEmployee(field){
            $.ajax({
                type:'post',
                url:'/update-employee',
                data:field,
                success:function(response){
                    if(response.success){
                        console.log('Employee data updated!');
                        //displayMembers();
                    }
                    else{
                        console.log("Failed to update employee data!");
                    }
                },
                error:function(error){
                    console.error("Update employee request error: ",error);
                }
            });
        }
        function updateStudent(field){
            $.ajax({
                type:'post',
                url:'/update-student',
                data:field,
                success:function(response){
                    if(response.success){
                        console.log('Student data updated!');
                        displayMembers();   
                    }
                    else{
                        console.log("Failed to update student data!");
                    }
                },
                error:function(error){
                    console.error("Update student request error: ",error);
                }
            })
        }
        $("#update-form").submit(function(e){
            e.preventDefault();
            let field ={
                uid:"",
                firstname:"",
                middlename:"",
                lastname:"",
                role:"",
            }
            field.uid=$("#uidRead").val();
            field.firstname=$("#firstnameRead").val();
            field.middlename=$("#middlenameRead").val();
            field.lastname=$("#lastnameRead").val();
            field.role=$("#roleRead").val();
            updateHandler(field);
        });
        $("#add-form").submit(function(e){
            e.preventDefault();
            let field = {
              uid:"",
              school:"Saint Joseph College of Novaliches",
              firstname:"",
              middlename:"",
              lastname:"",
              role:"",
            };
            field.uid = $('#uidInput').val();
            field.firstname = $('#firstnameInput').val();
            field.middlename = $('#middlenameInput').val();
            field.lastname = $('#lastnameInput').val();
            field.role = $('#roleInput').val();
            addEmployee(field);
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>  
</body>
</html>
