<main class="d-flex w-100">
    <section class="page-container w-100">
        <header class="page-title flex-start">
            <h2>Students</h2>
        </header>

        <section class="flex-center flex-wrap w-100">
            <input type="text" placeholder="search" id="txtbx_search" class="searchbox rounded-pill">
            <button class="rounded custom-btn">Filter</button>
            <a href="./index.php?page=user&action=student">
                <button class="rounded custom-btn">Add User</button>
            </a>
            <button class="rounded custom-btn" data-bs-toggle="modal" data-bs-target="#importstudent">Import</button>
        </section>

        <section class="flex-center">
            <table class="user-table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Year</th>
                        <th>Section</th>
                        <th>Course</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $studentList = studentData();

                    while($row = $studentList->fetch_assoc()){
                        ?>
                        <tr class="table-row" id="<?= $row['user_id']?>">
                        <td class="text-end">
                            <a href="./index.php?page=user&id=<?= $row['user_id']?>">
                                <img src="../assets/images/user.jpg" alt="" class="user-profile" width="35px">
                            </a>
                        </td>
                        <td><?= $row['firstname'] . ' '. $row['lastname']?></td>
                        <td><?= $row['year_level']?></td>
                        <td><?= $row['section']?></td>
                        <td><?= $row['course']?></td>
                    </tr>
                        <?php
                    }
                    ?>
                    
                    
                </tbody>
            </table>
        </section>
    </section>

    
</main>

<?php
include '../shared/modals.php';
?>