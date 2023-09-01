<main class="d-flex w-100">
    <section class="page-container w-100">
        <header class="page-title flex-start">
            <h2>Faculty Members</h2>
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
                        <th>Email</th> 
                        <th>Status</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $facultyList = facultyData();

                    while($row = $facultyList->fetch_assoc()){
                        ?>
                        <tr>
                        <td class="text-end">
                            <img src="../assets/images/user.jpg" alt="" class="user-profile" width="35px">
                        </td>
                        <td><?= $row['firstname'] . ' '. $row['lastname']?></td>
                        <td><?= $row['email']?></td>
                        <td><?= $row['employment_status']?></td>
                    
                    </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </section>

    
</main>