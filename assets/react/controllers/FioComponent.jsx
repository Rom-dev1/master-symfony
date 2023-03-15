import React, { useState } from 'react';
import axios from 'axios';

export default function (props) {
    let [show, setShow] = useState(false);

    let [data, setData] = useState({name: ''});
    let [errors, setErrors] = useState({});
    let [success, setSuccess] = useState();

    let handleChange = (event) => {
        setData({ ...data, ...{ [event.target.name]: event.target.value } });
    }

    let handleSubmit = (event) => {
        event.preventDefault();

        setErrors({});

        axios.post('/fio/create', data)
            .then(response => setSuccess(response.data.message))
            .catch(errors => setErrors(errors.response.data));
    }

    return (
        <div className="mt-6">
            {show &&
                <>
                    <h1 className="text-6xl text-slate-800">and hello React 🚀</h1>
                    <p className="text-4xl text-gray-400">And {props.fullName} again and again 🧸</p>
                </>
            }
            <button className="mt-6 bg-slate-600 rounded-lg text-white px-3 py-2 hover:bg-slate-400" onClick={() => setShow(!show)}>And who ?</button>

            <form className="my-3" method="post" onSubmit={handleSubmit}>
                <div>
                    <label htmlFor="name" className="mr-2">Nom</label>
                    <input type="text" name="name" id="name" value={data.name} onChange={handleChange} />
                    {errors.name && <p className="text-red-500">{errors.name}</p>}
                </div>
                <button className="mt-6 bg-slate-600 rounded-lg text-white px-3 py-2 hover:bg-slate-400">Envoyer</button>
            </form>

            {success && <p className="text-emerald-500">{success}</p>}
        </div>
    );
}
