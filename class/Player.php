<?php

class Player {
    private $userId;
    private $rank;
    private $userName;
    private $userDescription;
    private $avatar;
    private $userStr;
    private $userResi;
    private $userInt;
    private $userHp;
    private $userMaxHp;
    private $userLevel;
    private $exp;
    private $limitExp;
    private $energy;
    private $maxEnergy;
    private $gold;
    private $zalogowany;

    public function setUserId($id) {
        $this->userId = $id;
    }
    public function getUserId() {
        return $this->userId;
    }

    public function getRank() {
        return $this->rank;
    }

    public function setRank($rank) {
        $this->rank = $rank;
    }

    public function getUserName() {
        return $this->userName;
    }

    public function setUserName($userName) {
        $this->userName = $userName;
    }

    public function getUserDescription() {
        return $this->userDescription;
    }

    public function setUserDescription($userDescription) {
        $this->userDescription = $userDescription;
    }

    public function getAvatar() {
        return $this->avatar;
    }

    public function setAvatar($avatar) {
        $this->avatar = $avatar;
    }

    public function getUserStr() {
        return $this->userStr;
    }

    public function setUserStr($userStr) {
        $this->userStr = $userStr;
    }

    public function getUserResi() {
        return $this->userResi;
    }

    public function setUserResi($userResi) {
        $this->userResi = $userResi;
    }

    public function getUserInt() {
        return $this->userInt;
    }

    public function setUserInt($userInt) {
        $this->userInt = $userInt;
    }

    public function getUserHp() {
        return $this->userHp;
    }

    public function setUserHp($userHp) {
        $this->userHp = $userHp;
    }

    public function getUserMaxHp() {
        return $this->userMaxHp;
    }

    public function setUserMaxHp($userMaxHp) {
        $this->userMaxHp = $userMaxHp;
    }

    public function getUserLevel() {
        return $this->userLevel;
    }

    public function setUserLevel($userLevel) {
        $this->userLevel = $userLevel;
    }

    public function getExp() {
        return $this->exp;
    }

    public function setExp($exp) {
        $this->exp = $exp;
    }

    public function setZalogowany($status) {
        $this->zalogowany = $status;
    }

    public function getZalogowany(){
        return $this->zalogowany;
    }

    public function getLimitExp() {
        return $this->limitExp;
    }

    public function setLimitExp($limitExp) {
        $this->limitExp = $limitExp;
    }

    public function getEnergy() {
        return $this->energy;
    }

    public function setEnergy($energy) {
        $this->energy = $energy;
    }

    public function getMaxEnergy() {
        return $this->maxEnergy;
    }

    public function setMaxEnergy($maxEnergy) {
        $this->maxEnergy = $maxEnergy;
    }

    public function getGold() {
        return $this->gold;
    }

    public function setGold($gold) {
        $this->gold = $gold;
    }

}
?>
