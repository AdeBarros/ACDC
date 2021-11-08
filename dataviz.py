# -*- coding: utf-8 -*-
"""
Created on Tue Jun  1 14:57:43 2021

@author: Antoine De Barros
"""

import plotly.graph_objects as go
from plotly.subplots import make_subplots
from flask import Flask, request, jsonify, render_template
from flask_cors import CORS
import json
#import plotly.express as 

app = Flask(__name__)
cors = CORS(app)

# Cas de l'appel "/postmethod" utilisé lors de l'appui sur "Refresh Datavis" sur l'interface
@app.route("/postmethod", methods=['GET', 'POST'])
def datavis():
    # Retrieve input data as JSON
    #json_x_new = request.json

    fig = go.Figure()
    fig = make_subplots(1, 1)
    
    
    # definition fonction ajout de ligne (utilisée lors des tests)
    def addLine(figure, xx0,yy0, xx1, yy1, coolor):
        figure.add_shape(type='line',
            x0=xx0,
            y0=yy0,
            x1=xx1,
            y1=yy1,
            line=dict(
                color=coolor,width=2,
            dash="dashdot"
            ))
    
    
    # definition fonction ajout de bandes
    def addSpans(figure,width):
        for i in range (-1, 10):
            figure.add_shape(
                type='rect',
                x0=0,
                y0=2*i+1,
                x1=width,
                y1=2*i+2,
                fillcolor="grey",
                opacity= 0.2,
                line=dict(width=0)
            )
    
    # definition de la fonction de position de la Force
    def forcPos(long, agent):
        if(agent == '2'):
            return long - 0.5
        else:
            return 8.5 - long
        
    # definition de la fonction de retournement de l'image
    def imgFlip(agini, long, difagini):
        if (agini == "2" and difagini == "0") or (agini == "1" and difagini == "1"):
            if long % 2 == 1:
                return "flip"
            else:
                return ""
        else:
            if long % 2 == 1:
                return ""
            else:
                return "flip"

    def decFlip(agini):
        if(agini == "1"):
            return ""
        else:
            return "flip"
    
    #test de addline
    #addLine(fig, 3,2,3,5,'Blue')
    #test de addshape
    """
    fig.add_shape(
            type='line',
            x0=2,
            y0=1,
            x1=2,
            y1=5,
            line=dict(
                color='Red',
            width=4,
            dash="dot"
            )
    )
    """    

    # Récupération données fetch()
    json_x_new = request.json
    
    print(f"Prediction API called. Input data: {json_x_new}")
         
    # cas de différents types d'entrée de la variable fetch()
    if(json_x_new != None):
        if(type(json_x_new) == dict):
            dict_x_new = json_x_new
        else:
            dict_x_new = json.loads(json_x_new.read())
    else:
        dict_x_new = {}
    
    print(len(dict_x_new))
    
    # definition de la largeur du plot
    
    """ Solution temp alignement audio-frise
    # cas frise vide
    if len(dict_x_new) == 0:
        width = 9.83

    # cas frise utilisée moins d'1 min
    elif float(dict_x_new[str(len(dict_x_new)-1)]["temp"].split(":")[0]) < 1:
        width = 0.81
    # cas générique
    else:
        lastDict = dict_x_new[str(len(dict_x_new)-1)]
        widthstr = lastDict["temp"]
        widthtemp = widthstr.split(":")    
        widthmin = int(widthtemp[0])
        widthsec = int(widthtemp[1])
        width = widthmin + widthsec/60  
        
    """
    width = 9.8 # !!! A supprimer lors de la suppression de la somution temp
    
    # ajout des bandes grises
    addSpans(fig, width + 0.2)
       
    # mise à jour des axes
    fig.update_xaxes(
            tickangle = 10,
            title_text = "Durée en minutes",
            title_font = {"size": 20},
            title_standoff = 10,
            #nticks=5,
            #tick0=2.5, 
            #dtick=1,
            tickvals=[1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19],
            range=[0, width + 0.2]
    )
    fig.update_yaxes(
            tickangle = 0,
            title_text = "Longueur de l'échange",
            title_font = {"size": 20},
            title_standoff = 10,
            #nticks=5,
            #tick0=2.5, 
            #dtick=1,
            tickvals=[0, 1, 2, 3, 4, 5, 6, 7, 8],
            range=[-1, 9]
    )
    
    # Remplissage de la datavis    
    for i in range(len(dict_x_new)):
        istring = str(i)
        ech_dict = dict_x_new[istring]

        if ech_dict["temp"] != None:
        
            sptemp = ech_dict["temp"].split(":")
            minutes = int(sptemp[0])
            sec = int(sptemp[1])
            temp = minutes + sec/60

            # Ajout de l'évènement
            if(ech_dict["evt"] != None):
                fig.add_layout_image(
                dict(
                    source="http://localhost/ACDC/templates/Images/{}.png".format("Evenement"),
                    xref="x",
                    yref="paper",
                    xanchor='center',
                    yanchor='middle',
                    x=temp,
                    y=-0.05,
                    sizex=0.13,
                    sizey=0.66,
                    sizing="contain",
                    opacity=1,
                    layer="below"
                    )
                )
            
            if(ech_dict["force"] != "" and ech_dict["force"] != None):
                
            
                if ech_dict["agini"] == "2":
                    ydeci = int(ech_dict["long"]) + 0.33
                else:
                    ydeci = 7.66 - int(ech_dict["long"])
            
                if(ech_dict["deci"]):
                    # Ajout de la Décision
                    fig.add_layout_image(
                        dict(
                            source="http://localhost/ACDC/templates/Images/{}{}.png".format(ech_dict["deci"], decFlip(ech_dict["agini"])),
                            xref="x",
                            yref="y",
                            xanchor='center',
                            yanchor='middle',
                            x=temp,
                            y=ydeci,
                            sizex=0.7,
                            sizey=0.7,
                            sizing="contain",
                            opacity=1,
                            layer="above"
                            )
                        )
                
                # Ajout de la Force
                for l in range(int(ech_dict["long"])+1):
                    fig.add_layout_image(
                    dict(
                        source="http://localhost/ACDC/templates/Images/{}.png".format(ech_dict["force"]),
                        xref="x",
                        yref="y",
                        xanchor='center',
                        yanchor='middle',
                        x=temp,
                        y=forcPos(l, ech_dict["agini"]),
                        sizex=0.22,
                        sizey=1,
                        sizing="contain",
                        opacity=1,
                        layer="below"
                        )
                    )
                # Test
                # addLine(fig, temp, agent, temp, abs(int(ech_dict["long"])-abs(agent)+1), "black")
                        

                # Puis on s'attaque à leurs interactions
                j=0        
                while(j < len(ech_dict)-7):
                    int_dict = ech_dict[str(j)]

                    # cas de la coupure
                    if int_dict["type"] == "coupure":
                        # on donne sa position
                        if ech_dict["agini"] == "2":
                            yinter = int(int_dict["temp"])
                        else:
                            yinter = 8 - int(int_dict["temp"])
                        
                        # Ajout de la coupure
                        fig.add_layout_image(
                        dict(
                            source="http://localhost/ACDC/templates/Images/{}.png".format("coupure"),
                            xref="x",
                            yref="y",
                            xanchor='center',
                            yanchor='middle',
                            x=temp,
                            y=yinter,
                            sizex=0.6,
                            sizey=0.6,
                            sizing="contain",
                            opacity=1,
                            layer="above",
                            )
                        )
                    # cas des interactions
                    else:

                        # on donne sa position
                        if ech_dict["agini"] == "2":
                            yinter = int(int_dict["temp"]) - 0.5
                        else:
                            yinter = 8.5 - int(int_dict["temp"])  

                        
                        # cas de la superposition
                        if j+1 < len(ech_dict)-7 and ech_dict[str(j+1)]["temp"] == int_dict["temp"] and ech_dict[str(j+1)]["type"] != "coupure":
                            # Ajout de la 1e interaction
                            fig.add_layout_image(
                            dict(
                                source="http://localhost/ACDC/templates/Images/{}{}.png".format(int_dict["type"], imgFlip(ech_dict["agini"],int(int_dict["temp"]),ech_dict["dini"])),
                                xref="x",
                                yref="y",
                                xanchor='center',
                                yanchor='middle',
                                x=temp,
                                y=yinter+0.20,
                                sizex=0.6,
                                sizey=0.6,
                                sizing="contain",
                                opacity=1,
                                layer="above",
                                )
                            )

                            j += 1
                            int_dict = ech_dict[str(j)]

                            # Ajout de la 2e interaction
                            fig.add_layout_image(
                            dict(
                                source="http://localhost/ACDC/templates/Images/{}{}.png".format(int_dict["type"], imgFlip(ech_dict["agini"],int(int_dict["temp"]),ech_dict["dini"])),
                                xref="x",
                                yref="y",
                                xanchor='center',
                                yanchor='middle',
                                x=temp,
                                y=yinter-0.20,
                                sizex=0.6,
                                sizey=0.6,
                                sizing="contain",
                                opacity=1,
                                layer="above",
                                )
                            )

                        else:
                            # Ajout d'une interaction
                            fig.add_layout_image(
                            dict(
                                source="http://localhost/ACDC/templates/Images/{}{}.png".format(int_dict["type"], imgFlip(ech_dict["agini"],int(int_dict["temp"]),ech_dict["dini"])),
                                xref="x",
                                yref="y",
                                xanchor='center',
                                yanchor='middle',
                                x=temp,
                                y=yinter,
                                sizex=0.6,
                                sizey=0.6,
                                sizing="contain",
                                opacity=1,
                                layer="above",
                                )
                            )
                    
                    j += 1

    # On écrit la datavis dans un fichier HTML qu'on reprend dans l'interface
    fig.write_html("newdatavis.html")
    return ""

    