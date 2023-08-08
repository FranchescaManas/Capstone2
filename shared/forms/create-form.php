<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Form</title>
    <link rel="stylesheet" href="../css/forms.css">
    <link rel="stylesheet" href="../css/components.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
     <!-- Bootstrap css cdn -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
     <style>
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(223, 222, 222, 0.73); /* Gray color with 0.6 opacity */
            z-index: -1;
        }

     </style>
</head>
<body>
    <header>
        <?php include '../navbar.php'; ?>
    </header>

    <main >

        <form action="" id="form">

            <header class="field-group form-title">
                    <label for="form-title">Form Title:</label>
                    <input type="text" name="form-title" id="">  
            </header>
            <aside class="form-group-add">
                <a href="">
                    <i class="fa-solid fa-plus fa-2xl"></i>
                </a>
            
            </aside>

            <div class="field-group ">
                <section class="w-100 ">
                    <input type="text" class="field-question rounded" placeholder="Question">
                    <select name="field-option" class="field-option rounded">
                        <option value="short-paragraph">Short Paragraph</option>
                        <option value="linear">Linear Scale</option>
                        <option value="dropdown">Dropdown</option>
                        <option value="section">Section</option>
                        <option value="table">Table</option>
                        <option value="date">Date</option>
                        <option value="time">Time</option>
                    </select>
                </section>
                <section class="form-options w-100 my-1">
                    <a href="#" class="form-add-option">
                        <small>
                             Add option or <u>import from excel</u>
                        </small>
                    </a>

                </section>
                
            </div>
        </form>

    </main>

    <!-- bootstrap js cdn -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>
</html>