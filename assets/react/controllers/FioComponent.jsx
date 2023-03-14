import React, { useState } from 'react';

export default function (props) {
    let [show, setShow] = useState(false);

    return (
        <div className="mt-6">
            {show &&
                <>
                    <h1 className="text-6xl text-slate-800">and hello React 🚀</h1>
                    <p className="text-4xl text-gray-400">And {props.fullName} again and again 🧸</p>
                </>
            }
            <button className="mt-6 bg-slate-600 rounded-lg text-white px-3 py-2 hover:bg-slate-400" onClick={() => setShow(!show)}>And who ?</button>
        </div>
    );
}
