import pickle
import pandas as pd
from flask import Flask, request, jsonify
from flask_cors import CORS
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity
app = Flask(__name__)
CORS(app)
# app = Flask(__name__)

# 1. Load Data Produk
with open("df.pkl", "rb") as file:
    df_produk = pickle.load(file)  

# 2. Load TF-IDF Matrix
with open("tfidf_matrix.pkl", "rb") as file:
    tfidf_matrix = pickle.load(file)  

# 3. Load Model KNN
with open("knn_model.pkl", "rb") as file:
    knn_model = pickle.load(file)

# API 1: Mengambil Data Produk
@app.route("/get_products", methods=["GET"])
def get_products():
    return jsonify(df_produk.to_dict(orient="records"))

# API 2: Rekomendasi Produk
@app.route("/recommend_by_product", methods=["GET"])
def recommend_by_product():
    global df_produk, tfidf_matrix
    selected_product = request.args.get("product_name", None)
    input_hair_type = request.args.get("hair_type", None)  

    if not selected_product:
        return jsonify({"error": "Silakan pilih produk"}), 400

    try:
        df_produk = df_produk.reset_index(drop=True)
        matched = df_produk[df_produk["Name"] == selected_product]

        if matched.empty:
            return jsonify({"error": "Produk tidak ditemukan"}), 400

        product_index = matched.index[0]
        # 1. Cosine similarity
        product_vector = tfidf_matrix[product_index]
        cbf_similarities = cosine_similarity(product_vector, tfidf_matrix).flatten()

        # 2. Ambil top 50 produk paling mirip (selain dirinya sendiri)
        top_50_indices = cbf_similarities.argsort()[-101:-1][::-1]  # [-51:-1] untuk skip dirinya sendiri

        # 3. Fit KNN hanya pada top 50 hasil dari CBF
        tfidf_top = tfidf_matrix[top_50_indices]
        knn_model.fit(tfidf_top)

        # 4. Cari tetangga terdekat dari produk yang dipilih dalam space top-50
        _, knn_indices = knn_model.kneighbors(product_vector, n_neighbors = 100)

        # 5. Ambil index asli dari hasil rekomendasi
        final_indices = [top_50_indices[i] for i in knn_indices.flatten()]

        recommended = []
        for idx in final_indices:
            product = df_produk.iloc[idx].to_dict()
            if input_hair_type:
                if int(input_hair_type) == product.get("Cluster"):
                    recommended.append(product)
            else:
                recommended.append(product)
            if len(recommended) == 10:
                break
        print("rekomendasi :",recommended)
        return jsonify({"recommendations": recommended})
    
    except Exception as e:
        return jsonify({"error": str(e)}), 500



@app.route("/recommend_by_hair_type", methods=["GET"])
def recommend_by_hair_type():
    selected_hair_type = request.args.get("hair_type", type=int)
    selected_brand = request.args.get("brand", type=str)

    if selected_hair_type is None:
        return jsonify({"error": "Silakan pilih jenis rambut"}), 400

    if selected_brand:
        # Filter brand secara case-insensitive
        df_filtered = df_produk[df_produk["Brand"].str.lower() == selected_brand.lower()]
        # Filter jenis rambut
        print(len(df_filtered))
        print(df_filtered)

        df_filtered = df_filtered[df_filtered["Cluster"] == selected_hair_type]
        # print(len(df_filtered))
    else:
        df_filtered = df_produk[df_produk["Cluster"] == selected_hair_type]

    print(len(df_filtered))
    # Memeriksa apakah setelah filter masih ada produk
    if df_filtered.empty:
        return jsonify({"error": "Tidak ada produk untuk jenis rambut ini dan brand tersebut"}), 400

    # Mengambil 10 produk secara acak
    recommended_products = df_filtered.sample(n=min(10, len(df_filtered))).to_dict(orient="records")

    return jsonify({"recommendations": recommended_products})

@app.route("/get_hair_types_by_brand", methods=["GET"])
def get_hair_types_by_brand():
    selected_brand = request.args.get("brand", type=str)

    if not selected_brand:
        return jsonify({"error": "Brand harus dipilih"}), 400

    # Case-insensitive filter
    df_filtered = df_produk[df_produk["Brand"].str.lower() == selected_brand.lower()]

    if df_filtered.empty:
        return jsonify({"hair_types": []})

    unique_clusters = df_filtered["Cluster"].unique()

    label_map = {
        0: "Kering",
        1: "Rontok",
        2: "Berminyak",
        3: "Bewarna"
    }

    hair_types = [
        {"value": int(cluster), "label": label_map.get(int(cluster), "Tidak diketahui")}
        for cluster in unique_clusters
    ]

    return jsonify({"hair_types": hair_types})

if __name__ == "__main__":
    app.run(debug=True)
