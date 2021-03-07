<?php
class Pagination {
  	
    //클래스 내부에서 하단 페이지넘버 처리에 필요한 변수
    private
    $page,
    $total_page,
    $first_page,
    $last_page,
    $prev_page,
    $next_page,
    $total_block,
    $next_block,
    $next_block_page,
    $prev_block,
    $prev_block_page;
	
    //클래스 외부에서 필요한 변수
    public
    $limit_idx,
    $page_set;
      
    //페이지 줄수, 블럭수, 데이터베이스이름을 받아 데이터 정리
    public function __construct($pg, $bl, $total, $page) {
    
        $this->page_set = $pg; // 한페이지 줄수
        $block_set = $bl; // 한페이지 블럭수
    
        $this->total_page = ceil($total / $this->page_set); // 총페이지수(올림함수)
        $this->total_block = ceil($this->total_page / $block_set); // 총블럭수(올림함수)
    
        $this->page = ($page ? $page : 1); //파라미터로 현재 페이지정보를 받아옴
        $block = ceil($this->page/$block_set); // 현재블럭(올림함수)
        $this->limit_idx = ($this->page - 1) * $this->page_set; // limit시작위치
    
        $this->first_page = (($block - 1) * $block_set) + 1; // 첫번째 페이지번호
        $this->last_page = min ($this->total_page, $block * $block_set); // 마지막 페이지번호
   
        $this->prev_page = $this->page - 1; // 이전페이지
        $this->next_page = $this->page + 1; // 다음페이지
    
        $this->prev_block = $block - 1; // 이전블럭
        $this->next_block = $block + 1; // 다음블럭
    
        // 이전블럭을 블럭의 마지막으로 하려면...
        $this->prev_block_page = $this->prev_block * $block_set; // 이전블럭 페이지번호    
    
        // 이전블럭을 블럭의 첫페이지로 하려면...
        //$prev_block_page = $prev_block * $block_set - ($block_set - 1);
    
        $this->next_block_page = $this->next_block * $block_set - ($block_set - 1); // 다음블럭 페이지번호
        
    }
    
    //하단 페이지 넘버링
    public function getPaginationHTML(){

        echo '<nav>';
        echo '<ul class="pagination">';
      
        // 이전 블럭
        echo ($this->prev_block > 0) 
            ? '<li class="page-item"><a href="?page='.$this->prev_block_page.'" class="page-link">&laquo;</a></li>' 
            : '<li class="page-item disabled"><a href="#" class="page-link">&laquo;</a></li>';
        
        // 이전 페이지
        echo ($this->prev_page > 0)
            ? '<li class="page-item"><a href="?page='.$this->prev_page.'" class="page-link">&lsaquo;</a></li>' 
            : '<li class="page-item disabled"><a href="#" class="page-link">&lsaquo;</a></li>';

        for ($i=$this->first_page; $i<=$this->last_page; $i++) {

            echo ($i != $this->page)
            ? '<li class="page-item"><a href="?page='.$i.'" class="page-link">'.$i.'</a></li>' 
            : '<li class="page-item active"><a href="?page='.$i.'" class="page-link">'.$i.'</a></li>';

        }

        // 다음 페이지
        echo ($this->next_page <= $this->total_page)
            ? '<li class="page-item"><a href="?page='.$this->next_page.'" class="page-link">&rsaquo;</a></li>' 
            : '<li class="page-item disabled"><a href="#" class="page-link">&rsaquo;</a></li>';

        // 다음 블럭
        echo ($this->next_block <= $this->total_block)
            ? '<li class="page-item"><a href="?page='.$this->next_block_page.'" class="page-link">&raquo;</a></li>' 
            : '<li class="page-item disabled"><a href="#" class="page-link">&raquo;</a></li>';


        echo '</ul>';
        echo '</nav>';
                    
    }

}
?>