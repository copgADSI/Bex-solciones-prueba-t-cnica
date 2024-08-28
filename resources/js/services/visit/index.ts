import axios from "axios";
import { Visit } from "../../interfaces/visit";

async function fetch(page: number = 1) {
    try {
        return await axios.get('/visits/get', { params: { page } })
    } catch (error) {
        throw error
    }
}

async function store(visit: Visit) {
    try {
        return await axios.post('/visits', visit)
    } catch (error) {
        throw error
    }
}

async function update(visit: Visit) {
    try {
        return await axios.put(`/visits/${visit.id}`, visit)
    } catch (error) {
        throw error
    }
}

async function destroy(id: string) {
    try {
        return await axios.delete(`/visits/${id}`)
    } catch (error) {
        throw error
    }
}


const visitService = {
    fetch,
    store,
    update,
    destroy
}

export default visitService
