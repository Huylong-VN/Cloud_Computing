<div class="container">
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-end">
            <?php
            if ($current_page > 3) {
                echo ("<li class='page-item'><a class='page-link' href='?per_page=" . $item_per_page . "&page=1'>First</a></li>");
            }
            for ($num = 1; $num <= $total_page; $num++) {
                if ($num != $current_page - 3 && $num < $current_page + 3) {
                    echo ("<li class='page-item'><a class='page-link' href='?per_page=" . $item_per_page . "&page=" . $num . "'>Page :". $num . "</a></li>");
                }
            }
            if ($current_page < $total_page - 3) {
                $end_page = $total_page;
                echo ("<a class='page-link' href='?per_page=" . $item_per_page . "&page=" . $end_page . "'>Last</a>");
            }
            ?>
        </ul>
    </nav>
</div>