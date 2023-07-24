<?php

class ClassDate
{
    private $entryDate;
    private $departureDate;
    private $dateDiff;

    #Prices
    private $hourValue = 7;
    private $hourValueCad = 2;
    

    public function getLocation($entryFinal, $departureFinal)
    {

        $this->entryDate = new DateTime($entryFinal);
        $this->departureDate = new DateTime($departureFinal);

        //Retornar a diferença de dois objetos

        $this->dateDiff = $this->entryDate->diff($this->departureDate);
        $finalValue = 0;



        if ($this->dateDiff->h > 0) {
            $finalValue += $this->dateDiff->h * $this->hourValue;
        }
     

        return $finalValue;
    }
    public function getLocationCad($entryFinal, $departureFinal)
    {

        $this->entryDate = new DateTime($entryFinal);
        $this->departureDate = new DateTime($departureFinal);

        //Retornar a diferença de dois objetos
        $this->dateDiff = $this->entryDate->diff($this->departureDate);
        $finalValue = 0;

      
        if ($this->dateDiff->h > 0) {
            $finalValue += $this->dateDiff->h * $this->hourValueCad;
        }

        if ($this->dateDiff->i >= 30 ) {
            $finalValue +=  $this->hourValueCad;
        }
      
     

        return $finalValue;
    }
}
