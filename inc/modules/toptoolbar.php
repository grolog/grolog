
<body>
                       <table>
                            <tr>
                                <td>
                                    <a href = "index.php">Home</a>
                                </td>
<?php
if ($userAdmin == "Y") {
?>
                                <td>
                                    <a href = "admin.php">Admin Control Panel</a>
                                </td>
<?php
}
?>
                            </tr>

                        </table>