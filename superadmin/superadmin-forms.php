<!-- 
    Overall design of the forms page

    Included in superadmin/index.php
 -->
<main class="d-flex w-100">
    <section class="page-container">

        <header class="page-title">
            <h2>Forms</h2>
        </header>

        <section class="flex-center flex-column">
            <?php
                loadFormsGroup();
            ?>
            

        </section>

    </section>

    <aside class="summary-container flex-col-center">
        <a href="../shared/forms/create-form.php" class="w-100 flex-center" style="text-decoration: none;">
            <button class="white-btn">CREATE FORM</button>
        </a>
        <button class="white-btn" data-bs-toggle="modal" data-bs-target="#scheduleform">SCHEDULE FORM</button>
        <button class="white-btn" data-bs-toggle="modal" data-bs-target="#assignForm">ASSIGN FORM</button>
        <!-- Button trigger modal -->
        <?php include './super-admin-modal.php'; ?>

    </aside>

   
    
</main>