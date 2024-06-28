class PriceHelper {
    constructor(nbPerson, nbNight, priceUniqueNight) {
        this.nbPerson = nbPerson;
        this.nbNight = nbNight;
        this.priceUniqueNight = priceUniqueNight;
        this.TVA = 0.2;

        // Calculs à faire
        this.priceMultipleNight = this.priceUniqueNight * this.nbNight;
        this.serviceFee = this.priceMultipleNight * 0.01;
        this.touristTax = this.nbNight * this.nbPerson;
        this.totalHT = this.priceMultipleNight + this.serviceFee + this.touristTax;
        this.totalTVA = this.totalHT * this.TVA;
        this.totalTTC = this.totalHT + this.totalTVA;
    }

    getNbPerson() {
        return this.nbPerson;
    }

    getNbNight() {
        return this.nbNight;
    }

    getPriceUniqueNight() {
        return this.priceUniqueNight;
    }

    getServiceFee() {
        return this.serviceFee;
    }

    getPriceMultipleNight() {
        return this.priceMultipleNight;
    }

    getTouristTax() {
        return this.touristTax;
    }

    getTotalHT() {
        return this.totalHT;
    }

    getTVA() {
        return this.TVA;
    }

    getTotalTVA() {
        return this.totalTVA;
    }

    getTotalTTC() {
        return this.totalTTC;
    }
}