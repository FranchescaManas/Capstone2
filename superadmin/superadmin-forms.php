
<main class="d-flex w-100">
    <section class="page-container">

        <header class="page-title">
            <h2>Forms</h2>
        </header>

        <section class="flex-center flex-column">
            <div class="form-card">
                <h4>{{form title}}</h4>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur sint veniam fuga inventore tempora numquam omnis esse natus cupiditate, id rerum! Vel dolore maiores quasi consequuntur. Rerum, aliquid praesentium itaque deserunt, deleniti temporibus libero corporis alias, beatae excepturi tenetur? Molestias.</p>

                <div class="d-flex justify-content-end">
                    <button class="red-btn small-btn rounded">View</button>
                </div>
            </div>
            <div class="form-card">
                <h4>{{form title}}</h4>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur sint veniam fuga inventore tempora numquam omnis esse natus cupiditate, id rerum! Vel dolore maiores quasi consequuntur. Rerum, aliquid praesentium itaque deserunt, deleniti temporibus libero corporis alias, beatae excepturi tenetur? Molestias.</p>

                <div class="d-flex justify-content-end">
                    <button class="red-btn small-btn rounded">View</button>
                </div>
            </div>
            

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