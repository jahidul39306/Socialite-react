import { Link, useNavigate } from "react-router-dom";
import axios from "axios";
import React, { useEffect } from "react";
import { useState } from "react";

const Post = () => {
    const [posts, setPosts] = useState({});

    useEffect(() => {
        axios.get("http://127.0.0.1:8000/api/post/allposts")
            .then(res => {
                setPosts(res.data);
            })
    }, []);

    return(
        <div>
            {posts.map((post) => {
                return <h1>{post["userName"]}</h1>;
            })}
        </div>
    )
}
export default Post;


