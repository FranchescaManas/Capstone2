<!-- 
    Overall design of the forms page

    Included in superadmin/index.php
 -->
 <?php
//  session_start();
    include_once $_SERVER['DOCUMENT_ROOT'] . '/capstone/shared/shared-functions.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/capstone/shared/forms/FormClass.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/capstone/shared/forms/form-modal.php'; 

    $userID = $_SESSION['user_id'];
    $role = $_SESSION['role'];

 ?>
<main class="d-flex w-100">
    <section class="page-container">

        <header class="page-title">
            <h2>Forms</h2>
        </header>

        <section class="flex-center flex-column">
            <?php
            
                $form = new Form;

                // searches the forms accessible to the current role and id
                $formId = $form->getFormID($userID, $role);

                foreach($formId as $f_id){
                    $access = $form->checkAccess($f_id, $role);
                    if($access === 'can access'){
                       
                        $form->loadFormsGroup($f_id);
                        
                    // if user has modification access, then display modify button
                    }else if($access === 'can modify'){
                        // no function yet
                        echo "user can modify";
                    }else if($access === 'full access'){
                        // no function yet
                        $form->loadFormsGroup($f_id);   
                    }else{
                        // design no permission message
                        echo "no permission to forms";
                    }

                }

                
            ?>
            

        </section>

    </section>

    <aside class="summary-container flex-col-center">
        <a href="../shared/forms/create-form.php" class="w-100 flex-center" style="text-decoration: none;">
            <button class="white-btn">CREATE FORM</button>
        </a>
        <button class="white-btn" data-bs-toggle="modal" data-bs-target="#scheduleform">SCHEDULE FORM</button>
        <button class="white-btn" data-bs-toggle="modal" data-bs-target="#assignForm">ASSIGN FORM</button>
    

    </aside>

   
    
</main>