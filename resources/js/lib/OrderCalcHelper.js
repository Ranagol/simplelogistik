class OrderCalcHelper {
    #calcVolume = (parcels = []) => {
        return parcels.reduce((acc, parcel) => {
            return acc + parseFloat(parcel.width) * parseFloat(parcel.height) * parseFloat(parcel.length);
        }, 0);
    }

    #calcArea = (parcels = []) => {
        return parcels.reduce((acc, parcel) => {
            return acc + parseFloat(parcel.width) * parseFloat(parcel.length);
        }, 0);
    }

    #calcWeight = (parcels = []) => {
        return parcels.reduce((acc, parcel) => {
            return acc + parseFloat(parcel.weight);
        }, 0);
    }

    calculate = (parcels = []) => {
        if(parcels.length === 0) {
            return {
                volume: "0",
                area: "0",
                weight: "0",
                count: parcels.length.toString(),
            }
        }
        return {
            volume: (this.#calcVolume(parcels)).toString(),
            area: (this.#calcArea(parcels)).toString(),
            weight: (this.#calcWeight(parcels)).toString(),
            count: parcels.length,
        }
    }
}

export default new OrderCalcHelper();