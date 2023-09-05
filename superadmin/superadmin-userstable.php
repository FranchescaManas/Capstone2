<main class="d-flex w-100">
    <section class="page-container w-100">
        <header class="page-title flex-start">
            <h2>Users</h2>
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
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    
                        $user = userData();

                        while($row = $user->fetch_array()){
                            ?>
                            <tr class="table-row" id="<?= $row['user_id']?>">
                            <td class="text-end">
                                <a href="./index.php?page=user&id=<?= $row['user_id']?>">
                                    <img src="../assets/images/user.jpg" alt="" class="user-profile" width="35px">
                                </a>
                            </td>
                            <td><?= $row['firstname']?></td>
                            <td><?= $row['lastname']?></td>
                            <td><?= $row['email']?></td>
                            <td><?= $row['role']?></td>
                        </tr>
                            <?php
                        }       

                        ?>
  
                </tbody>
            </table>
        </section>
    </section>

    
</main>
