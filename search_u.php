<?php
    header('Content-Type: application/json');
    
    if(!(isset($_POST['a'])))
    {
        header('Location: https://poscielecapri.pl/Jakub/Szkola/blog3');
        exit();
    }
    
    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);

    try
    {
        $conn = new mysqli($host, $db_user, $db_password, $db_name);

        if($conn->connect_errno!=0)
        {
            throw new Exception(mysqli_connect_errno());
        }
        else
        {
            $text=$_POST['a'];
            $text=htmlentities($text);

            if($text!="")
            {
                $sql="SELECT id,user,tytul FROM artykuly WHERE user LIKE '%$text%' ORDER BY user";
            } 
            else 
            {
                $sql="SELECT id,user,tytul FROM artykuly ORDER BY user";
            }
            $conn-> query('SET NAMES utf8');
            $result=$conn->query($sql);
            $wyniki=$result->num_rows;

            while($row=$result->fetch_array())
            {
                $rows[]=$row;
            }

            $conn->close();
        }
    }
    catch(Exception $e)
    {
        echo '<span style="color:red;">BŁĄD!</span>';
    }


    $dane[0][0]=$wyniki;

    for($i=0;$i<$wyniki;$i++)
    {
        $dane[$i][1]=$rows[$i]['id'];
        $dane[$i][2]=$rows[$i]['tytul'];
    }

    echo json_encode($dane);
?>