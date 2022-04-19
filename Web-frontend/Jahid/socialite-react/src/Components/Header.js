import { Link, useNavigate } from "react-router-dom";
import axios from "axios";
import React, { useEffect } from "react";
import { useState } from "react";
import Post from './Post';

const Header = () => {

    let [posts, setPosts] = useState([]);
    const navigate = new useNavigate();
    const [postText, setPostText] = useState("");
    const [formErrors, setFormErrors] = useState("");
    let newPost = null;

    const handleChange = (e) => {
        setPostText(e.target.value);
    }

    const handleSubmit = (e) => {
        e.preventDefault();
        if(postText.length === 0)
        {
            setFormErrors("Post can not be empty!");
        }
        else{
            axios.post("http://127.0.0.1:8000/api/post/create", {
                postData : postText,
                id : localStorage.getItem('userId')
            });
            setFormErrors("Post created");
            setPostText("");
            
        }
    };


    const Verify = () => {
        if (localStorage.getItem("isLoggedIn") !== "true") {
            navigate("/login");
        }
    }
    useEffect(() => {
        axios.get("http://127.0.0.1:8000/api/post/allposts")
            .then(res => {
                setPosts(res.data);
            })
    }, [formErrors]);

    const Logout = () => {
        localStorage.clear();
        navigate("/login");
    }
    return (
        <div className="w-full flex flex-row flex-wrap">
            <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
            <style dangerouslySetInnerHTML={{ __html: "\n  .round {\n    border-radius: 50%;\n  }\n" }} />
            <div className="w-screen bg-indigo-100 h-screen flex flex-row flex-wrap justify-center ">
                {/* Begin Navbar */}
                <div className="bg-white shadow-lg border-t-4 border-indigo-500 absolute bottom-0 w-full md:w-0 md:hidden flex flex-row flex-wrap">
                    <div className="w-full text-right"><button className="p-2 fa fa-bars text-4xl text-gray-600" /></div>
                </div>
                <div className="w-0 md:w-1/4 lg:w-1/5 h-0 md:h-screen overflow-y-hidden bg-white shadow-lg">
                    <div className="p-5 bg-white sticky top-0">
                        <img className="border border-indigo-100 shadow-lg round" src="http://lilithaengineering.co.za/wp-content/uploads/2017/08/person-placeholder.jpg" />
                        <div className="pt-2 border-t mt-5 w-full text-center text-xl text-gray-600">
                            {localStorage.getItem("name")}
                        </div>
                    </div>
                    <div className="w-full h-screen antialiased flex flex-col hover:cursor-pointer">
                        <a className="hover:bg-gray-300 bg-gray-200 border-t-2 p-3 w-full text-xl text-left text-gray-600 font-semibold" href><i className="fa fa-comment text-gray-600 text-2xl pr-1 pt-1 float-right" />Messages</a>
                        <a className="hover:bg-gray-300 bg-gray-200 border-t-2 p-3 w-full text-xl text-left text-gray-600 font-semibold" href><i className="fa fa-cog text-gray-600 text-2xl pr-1 pt-1 float-right" />Settings</a>
                        {/* <Link to="/logout" className="hover:bg-gray-300 bg-gray-200 border-t-2 p-3 w-full text-xl text-left text-gray-600 font-semibold"><i className="fa fa-arrow-left text-gray-600 text-2xl pr-1 pt-1 float-right" />Log out</Link> */}
                        <button onClick={Logout} className="block w-full bg-indigo-600 mt-4 py-2 rounded-2xl text-white font-semibold mb-2">Logout</button>
                    </div>
                </div>
                {/* End Navbar */}
                <div className="w-full md:w-3/4 lg:w-4/5 p-5 md:px-12 lg:24 h-full overflow-x-scroll antialiased">
                    <div className="w-3/4 bg-white w-full shadow rounded-lg p-5">
                        <textarea name="share" className="bg-gray-200 w-full rounded-lg shadow border p-2" rows={5} placeholder="Speak your mind" value={postText} onChange={handleChange}/>
                        <div className="w-full flex flex-row flex-wrap mt-3">
                            <div className="w-1/3">
                                <p>{formErrors}</p>
                            </div>
                            <div className="w-2/3">
                                <button onClick={handleSubmit} className="float-right bg-indigo-400 hover:bg-indigo-300 text-white p-2 rounded-lg">Submit</button>
                            </div>
                        </div>
                    </div>
                    {posts.reverse().map((post) => {
                        return (
                            <div className="w-3/4 mt-3 flex flex-col">
                                <div className="bg-white mt-3">
                                    <div className="bg-white p-3 text-xl text-green-700 font-semibold">
                                        {post.userName}
                                        <div className="bg-white text-sm text-black-700 font-semibold">{post.createdAt}</div>
                                    </div>
                                    <div className="bg-white border shadow p-5 text-xl text-black-700 font-semibold">
                                        {post.postText}
                                    </div>
                                    <div className="bg-white p-1 border shadow flex flex-row flex-wrap">
                                        <div className="w-1/3 hover:bg-gray-200 text-center text-xl text-gray-700 font-semibold">Like</div>
                                        <div className="w-1/3 hover:bg-gray-200 border-l-4 border-r- text-center text-xl text-gray-700 font-semibold">Share</div>
                                        <div className="w-1/3 hover:bg-gray-200 border-l-4 text-center text-xl text-gray-700 font-semibold">Comment</div>
                                    </div>
                                </div>
                            </div>
                        )
                    })}
                </div>
                
            </div>
        </div>

    )
}
export default Header;