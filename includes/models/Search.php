<?php

class Search
{
    private $SearchDAO;

	public function __construct($con)
	{
		$this->con = $con;
        $this->searchDAO = $SearchDAO($con);
	}

    public function getSearchFor($searchString)
    {
        
    }

   
}
