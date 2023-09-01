<main class="d-flex w-100">
    <section class="page-container w-100">
        <header class="page-title flex-start">
            <h2>Students</h2>
        </header>

        <section class="flex-center flex-wrap w-100">
            <input type="text" placeholder="search" id="txtbx_search" class="searchbox rounded-pill">
            <button class="rounded custom-btn">Filter</button>
            <button class="rounded custom-btn">Import</button>
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
                        <tr>
                        <td class="text-end">
                            <img src="../assets/images/user.jpg" alt="" class="user-profile" width="35px">
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